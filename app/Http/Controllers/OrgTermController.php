<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrgTerm;
use App\Models\User;

class OrgTermController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $isAdviserOrAdmin = $user && (in_array('adviser', $user->roles ?? []) || in_array('admin', $user->roles ?? []));
        $assignedOrgs = [];
        if ($isAdviserOrAdmin) {
            if (in_array('admin', $user->roles ?? [])) {
                $assignedOrgs = \App\Models\Org::all();
            } else {
                $assignedOrgs = $user->advisedOrgs ? $user->advisedOrgs()->get() : [];
            }
        }
        $participatedOrgTerms = OrgTerm::whereHas('org.positions.users', function($q) use ($user) {
            $q->where('users.id', $user->id);
        })->with('org')->get();
        $createdOrgTerms = OrgTerm::where('created_by', $user->id)->with('org')->get();

        return view('orgs.index', [
            'assignedOrgs' => $assignedOrgs,
            'createdOrgTerms' => $createdOrgTerms,
            'participatedOrgTerms' => $participatedOrgTerms,
            'isAdviserOrAdmin' => $isAdviserOrAdmin,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'org_id' => 'required|exists:orgs,id',
            'academic_year' => 'required|string|max:20',
        ]);
        if (OrgTerm::where('org_id', $validated['org_id'])->where('academic_year', $validated['academic_year'])->exists()) {
            return back()->withErrors(['academic_year' => 'This organization already exists for the selected academic year.'])->withInput();
        }
        $orgTerm = new OrgTerm();
        $orgTerm->org_id = $validated['org_id'];
        $orgTerm->academic_year = $validated['academic_year'];
        $orgTerm->created_by = auth()->id();
        $orgTerm->save();
        return redirect()->route('orgs.index')->with('success', 'Organization term created successfully.');
    }

    public function checkDuplicate(Request $request)
    {
        $orgId = $request->query('org_id');
        $year = $request->query('academic_year');
        $exists = false;
        if ($orgId && $year) {
            $exists = OrgTerm::where('org_id', $orgId)
                ->where('academic_year', $year)
                ->exists();
        }
        return response()->json(['exists' => $exists]);
    }

    public function show($id)
    {
        $orgTerm = \App\Models\OrgTerm::with([
            'org.department',
            'org.advisers',
            'org.positions.users'
        ])->findOrFail($id);

        $isAdviserOrAdmin = auth()->user() && (in_array('adviser', auth()->user()->roles ?? []) || in_array('admin', auth()->user()->roles ?? []));
        $advisers = $orgTerm->org->advisers ?? collect();
        $positions = $orgTerm->org->positions ?? collect();
        // For each position, only get users assigned for this org term
        $positions = $positions->map(function($position) use ($orgTerm) {
            $position->users = $position->usersForOrgTerm($orgTerm->id)->get();
            return $position;
        });
        // Collect all students assigned to any position in this org term
        $students = $positions->flatMap(function($position) {
            return $position->users;
        })->unique('id')->values();

        // Build evaluation status for each user
        $studentEvalStatus = [];
        foreach ($positions as $position) {
            foreach ($position->users as $user) {
                $studentEvalStatus[$user->id] = [
                    'self' => \App\Models\EvaluationResponse::where('org_term_id', $orgTerm->id)
                        ->where('user_id', $user->id)
                        ->where('evaluator_id', $user->id)
                        ->exists(),
                    'peer' => \App\Models\EvaluationResponse::where('org_term_id', $orgTerm->id)
                        ->where('user_id', $user->id)
                        ->where('evaluator_id', '!=', $user->id)
                        ->whereHas('evaluator', function($q) {
                            $q->whereJsonContains('roles', 'student');
                        })
                        ->exists(),
                    'adviser' => \App\Models\EvaluationResponse::where('org_term_id', $orgTerm->id)
                        ->where('user_id', $user->id)
                        ->whereHas('evaluator', function($q) {
                            $q->whereJsonContains('roles', 'adviser');
                        })
                        ->exists(),
                ];
            }
        }

        // TODO: Pass peerEvaluators if needed, for now pass as empty array if not set elsewhere
        $peerEvaluators = \DB::table('org_term_peer_evaluators')
            ->where('org_term_id', $orgTerm->id)
            ->get();

        // Calculate progress bars
        $totalStudents = $students->count();
        $adviserEvaluations = 0;
        $peerEvaluations = 0;
        $selfEvaluations = 0;
        if ($totalStudents > 0) {
            foreach ($students as $student) {
                // Adviser evaluation: at least one adviser evaluation exists for this student
                $adviserEvaluations += \App\Models\EvaluationResponse::where('org_term_id', $orgTerm->id)
                    ->where('user_id', $student->id)
                    ->whereHas('evaluator', function($q) {
                        $q->whereJsonContains('roles', 'adviser');
                    })->exists() ? 1 : 0;
                // Peer evaluation: at least one peer evaluation exists for this student (evaluator is student and not self)
                $peerEvaluations += \App\Models\EvaluationResponse::where('org_term_id', $orgTerm->id)
                    ->where('user_id', $student->id)
                    ->whereHas('evaluator', function($q) {
                        $q->whereJsonContains('roles', 'student');
                    })
                    ->whereColumn('evaluator_id', '!=', 'user_id')
                    ->exists() ? 1 : 0;
                // Self evaluation: at least one self evaluation exists for this student (evaluator is student and self)
                $selfEvaluations += \App\Models\EvaluationResponse::where('org_term_id', $orgTerm->id)
                    ->where('user_id', $student->id)
                    ->where('evaluator_id', $student->id)
                    ->whereHas('evaluator', function($q) {
                        $q->whereJsonContains('roles', 'student');
                    })
                    ->exists() ? 1 : 0;
            }
        }
        $adviserProgress = $totalStudents > 0 ? round(($adviserEvaluations / $totalStudents) * 100) : 0;
        $peerProgress = $totalStudents > 0 ? round(($peerEvaluations / $totalStudents) * 100) : 0;
        $selfProgress = $totalStudents > 0 ? round(($selfEvaluations / $totalStudents) * 100) : 0;

        // Determine if all evaluations are complete for all students
        $allEvaluationsComplete = true;
        foreach ($students as $student) {
            if (
                empty($studentEvalStatus[$student->id]['self']) ||
                empty($studentEvalStatus[$student->id]['peer']) ||
                empty($studentEvalStatus[$student->id]['adviser'])
            ) {
                $allEvaluationsComplete = false;
                break;
            }
        }

        return view('orgs.org_terms.show', compact('orgTerm', 'advisers', 'positions', 'isAdviserOrAdmin', 'students', 'peerEvaluators', 'studentEvalStatus', 'adviserProgress', 'peerProgress', 'selfProgress', 'allEvaluationsComplete'));
    }

    public function assignStudent(Request $request, $orgTermId)
    {
        $request->validate([
            'position_id' => 'required|exists:positions,id',
            'student_id' => 'required|exists:users,id',
        ]);

        $orgTerm = \App\Models\OrgTerm::with('org.positions', 'org')->findOrFail($orgTermId);
        $org = $orgTerm->org;
        $position = $org->positions->where('id', $request->position_id)->first();
        if (!$position) {
            return back()->withErrors(['position_id' => 'Invalid position for this organization term.']);
        }
        $student = \App\Models\User::findOrFail($request->student_id);
        // Department logic: if org has department, student must match; else allow all
        if ($org->department_id && $student->department_id != $org->department_id) {
            return back()->withErrors(['student_id' => 'Student does not belong to the required department.']);
        }
        // Enforce slot limit (count only for this org term and position)
        $currentCount = \DB::table('org_term_user')
            ->where('org_term_id', $orgTermId)
            ->where('position_id', $position->id)
            ->count();
        if ($currentCount >= $position->slots) {
            return back()->withErrors(['position_id' => 'This position has reached its slot limit.']);
        }
        // Attach student to org_term_user if not already assigned for this org term and position
        $exists = \DB::table('org_term_user')
            ->where('org_term_id', $orgTermId)
            ->where('position_id', $position->id)
            ->where('user_id', $student->id)
            ->exists();
        if (!$exists) {
            \DB::table('org_term_user')->insert([
                'org_term_id' => $orgTermId,
                'position_id' => $position->id,
                'user_id' => $student->id,
                'terms_served' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        return redirect()->route('org_terms.show', $orgTermId)->with('success', 'Student assigned to position successfully.');
    }

    public function removeStudent($orgTermId, $positionId, $userId)
    {
        $orgTerm = \App\Models\OrgTerm::with('org.positions')->findOrFail($orgTermId);
        $position = $orgTerm->org->positions->where('id', $positionId)->first();
        if ($position) {
            $position->users()->detach($userId);
        }
        return redirect()->route('org_terms.show', $orgTermId)->with('success', 'Student removed from position.');
    }

    // Search students for assignment modal (AJAX)
    public function searchStudents(Request $request, $orgTermId)
    {
        $query = $request->input('q');
        $students = \App\Models\User::whereJsonContains('roles', 'student')
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%$query%")
                  ->orWhere('email', 'like', "%$query%")
                  ->orWhere('first_name', 'like', "%$query%")
                  ->orWhere('last_name', 'like', "%$query%") ;
            })
            ->limit(10)
            ->get(['id', 'name', 'first_name', 'last_name', 'email']);
        // Always return a name for display
        $students->transform(function($student) {
            $student->name = trim($student->name) ?: trim($student->first_name . ' ' . $student->last_name);
            return $student;
        });
        return response()->json($students);
    }

    // Show assigned organization (user-side org show)
    public function showOrg($id)
    {
        $org = \App\Models\Org::with(['department', 'advisers', 'positions.users', 'creator'])->findOrFail($id);
        return view('orgs.show', compact('org'));
    }

    public function assignPeers(Request $request, $orgTermId)
    {
        $request->validate([
            'peer_1' => 'required|different:peer_2|exists:users,id',
            'peer_2' => 'required|different:peer_1|exists:users,id',
        ]);
        $orgTerm = \App\Models\OrgTerm::findOrFail($orgTermId);
        // Remove previous assignments for this org term
        \DB::table('org_term_peer_evaluators')->where('org_term_id', $orgTerm->id)->delete();
        // Assign new peers
        \DB::table('org_term_peer_evaluators')->insert([
            [
                'org_term_id' => $orgTerm->id,
                'peer_id' => $request->peer_1,
                'peer_number' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'org_term_id' => $orgTerm->id,
                'peer_id' => $request->peer_2,
                'peer_number' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        return redirect()->route('org_terms.show', $orgTermId)->with('success', 'Peer evaluators assigned successfully.');
    }

    public function startEvaluation(Request $request, $orgTermId)
    {
        $orgTerm = OrgTerm::findOrFail($orgTermId);
        // Only allow if not already in progress or closed
        if ($orgTerm->evaluation_state === 'in_progress') {
            return back()->withErrors(['evaluation_state' => 'Evaluation is already in progress.']);
        }
        if ($orgTerm->evaluation_state === 'closed') {
            return back()->withErrors(['evaluation_state' => 'Evaluation is already closed.']);
        }
        // Validate peer evaluators
        $request->validate([
            'peer_1' => 'required|different:peer_2|exists:users,id',
            'peer_2' => 'required|different:peer_1|exists:users,id',
        ]);
        // Remove previous assignments for this org term
        \DB::table('org_term_peer_evaluators')->where('org_term_id', $orgTerm->id)->delete();
        // Assign new peers
        \DB::table('org_term_peer_evaluators')->insert([
            [
                'org_term_id' => $orgTerm->id,
                'peer_id' => $request->peer_1,
                'peer_number' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'org_term_id' => $orgTerm->id,
                'peer_id' => $request->peer_2,
                'peer_number' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        // Find the assigned evaluation form for this org
        $form = $orgTerm->org->evaluationForms()->latest('evaluation_form_org.created_at')->first();
        if (!$form) {
            return back()->withErrors(['evaluation_form' => 'No evaluation form assigned to this organization.']);
        }
        // Set state to in_progress
        $orgTerm->evaluation_state = 'in_progress';
        $orgTerm->save();
        // Optionally: increment terms_served for all org_term_user records for this orgTerm
        \DB::table('org_term_user')
            ->where('org_term_id', $orgTerm->id)
            ->increment('terms_served');
        // Optionally: create an org_term_evaluation record here if you want to track instances
        return redirect()->route('org_terms.show', $orgTermId)->with('success', 'Evaluation started and peer evaluators assigned.');
    }

    public function cancelEvaluation(Request $request, $orgTermId)
    {
        $orgTerm = OrgTerm::findOrFail($orgTermId);
        // Only allow if in progress
        if ($orgTerm->evaluation_state !== 'in_progress') {
            return back()->withErrors(['evaluation_state' => 'Evaluation is not in progress.']);
        }
        $orgTerm->evaluation_state = 'cancelled';
        $orgTerm->save();
        // Remove peer evaluator assignments
        \DB::table('org_term_peer_evaluators')->where('org_term_id', $orgTerm->id)->delete();
        // Remove all evaluation responses for this org term
        \DB::table('evaluation_responses')->where('org_term_id', $orgTerm->id)->delete();
        // Optionally: revert any evaluation instance records if needed
        return redirect()->route('org_terms.show', $orgTermId)->with('success', 'Evaluation cancelled and all related data removed. You may now edit students and positions.');
    }

    public function evaluate($orgTermId, $userId)
    {
        $orgTerm = \App\Models\OrgTerm::with(['org'])->findOrFail($orgTermId);
        $student = User::findOrFail($userId);
        $evaluatorId = auth()->id();
        // Fetch the assigned evaluation form for this org
        $form = $orgTerm->org->evaluationForms()->latest()->first();
        if (!$form) {
            abort(404, 'No evaluation form assigned to this organization.');
        }
        // Eager load domains, strands, questions (questions will eager load likertScales)
        $formDomains = $form->domains()->with(['strands.questions.likertScales'])->get();
        // Check if already evaluated
        $existingResponses = \DB::table('evaluation_responses')
            ->where('org_term_id', $orgTermId)
            ->where('user_id', $userId)
            ->where('evaluator_id', $evaluatorId)
            ->pluck('score', 'question_id');
        // Check if evaluation is allowed (state, role, etc.)
        $canEvaluate = $orgTerm->evaluation_state === 'in_progress';
        return view('orgs.org_terms.evaluate', compact('orgTerm', 'student', 'formDomains', 'existingResponses', 'canEvaluate'));
    }

    public function submitEvaluation(Request $request, $orgTermId, $userId)
    {
        $orgTerm = \App\Models\OrgTerm::findOrFail($orgTermId);
        if ($orgTerm->evaluation_state !== 'in_progress') {
            return back()->withErrors(['evaluation_state' => 'Evaluation is not in progress.'])->withInput();
        }
        $evaluatorId = auth()->id();
        $responses = $request->input('responses', []);
        if (empty($responses)) {
            return back()->withErrors(['responses' => 'Please answer all questions.'])->withInput();
        }
        foreach ($responses as $questionId => $score) {
            \App\Models\EvaluationResponse::updateOrCreate(
                [
                    'org_term_id' => $orgTermId,
                    'user_id' => $userId,
                    'evaluator_id' => $evaluatorId,
                    'question_id' => $questionId,
                ],
                [
                    'score' => $score,
                ]
            );
        }
        // Audit log (simple):
        \Log::info('Evaluation submitted', [
            'org_term_id' => $orgTermId,
            'user_id' => $userId,
            'evaluator_id' => $evaluatorId,
            'responses' => $responses,
            'timestamp' => now(),
        ]);
        // (Optional) Notification stub
        // event(new \App\Events\EvaluationSubmitted($orgTermId, $userId, $evaluatorId));
        return redirect()->route('org_terms.show', $orgTermId)->with('success', 'Evaluation submitted successfully.');
    }

    public function results($orgTermId)
    {
        $orgTerm = \App\Models\OrgTerm::with(['org'])->findOrFail($orgTermId);
        $form = $orgTerm->org->evaluationForms()->latest()->first();
        if (!$form) {
            abort(404, 'No evaluation form assigned to this organization.');
        }
        $formDomains = $form->domains()->with(['strands.questions'])->get();
        // Aggregate results: average score per question
        $questionAverages = \App\Models\EvaluationResponse::where('org_term_id', $orgTermId)
            ->selectRaw('question_id, AVG(score) as avg_score, COUNT(*) as responses')
            ->groupBy('question_id')
            ->pluck('avg_score', 'question_id');
        // Length of service scoring (stub, implement as needed)
        // $lengthOfServiceScores = ...
        return view('orgs.org_terms.results', compact('orgTerm', 'formDomains', 'questionAverages'));
    }

    public function closeEvaluation($orgTermId)
    {
        $orgTerm = \App\Models\OrgTerm::findOrFail($orgTermId);
        $orgTerm->evaluation_state = 'closed';
        $orgTerm->save();

        // Compute and store evaluation results for all users in this org term
        $org = $orgTerm->org;
        $form = $org->evaluationForms()->latest()->first();
        if ($form) {
            $weights = $form->criteriaWeights->pluck('weight', 'evaluator_type');
            $adviserWeight = $weights['adviser'] ?? 0;
            $peerWeight = $weights['peer'] ?? 0;
            $selfWeight = $weights['self'] ?? 0;
            $serviceWeight = $weights['service'] ?? 0;
            foreach ($orgTerm->users as $user) {
                $adviserAvg = \App\Models\EvaluationResponse::where('org_term_id', $orgTerm->id)
                    ->where('user_id', $user->id)
                    ->whereHas('evaluator', function($q) { $q->whereJsonContains('roles', 'adviser'); })
                    ->avg('score') ?? 0;
                $peerAvg = \App\Models\EvaluationResponse::where('org_term_id', $orgTerm->id)
                    ->where('user_id', $user->id)
                    ->whereHas('evaluator', function($q) { $q->whereJsonContains('roles', 'student'); })
                    ->whereColumn('evaluator_id', '!=', 'user_id')
                    ->avg('score') ?? 0;
                $selfAvg = \App\Models\EvaluationResponse::where('org_term_id', $orgTerm->id)
                    ->where('user_id', $user->id)
                    ->where('evaluator_id', $user->id)
                    ->whereHas('evaluator', function($q) { $q->whereJsonContains('roles', 'student'); })
                    ->avg('score') ?? 0;
                $orgTypeId = $org->org_type_id ?? null;
                $serviceScore = 0;
                if ($orgTypeId) {
                    $serviceScore = \App\Models\OrgTerm::whereHas('org', function($q) use ($orgTypeId) {
                        $q->where('org_type_id', $orgTypeId);
                    })->whereHas('users', function($q) use ($user) {
                        $q->where('user_id', $user->id);
                    })->count();
                }
                $score = ($adviserAvg * $adviserWeight) + ($peerAvg * $peerWeight) + ($selfAvg * $selfWeight) + ($serviceScore * $serviceWeight);
                $rank = null;
                if ($score !== null) {
                    $rank = \App\Models\AwardRank::where('min_score', '<=', $score)
                        ->where('max_score', '>=', $score)
                        ->orderBy('order')->first();
                }
                \App\Models\EvaluationResult::updateOrCreate(
                    [
                        'org_term_id' => $orgTerm->id,
                        'user_id' => $user->id,
                    ],
                    [
                        'score' => $score,
                        'rank_id' => $rank ? $rank->id : null,
                    ]
                );
            }
        }

        return redirect()->route('org_terms.show', $orgTermId)->with('success', 'Evaluation phase ended successfully.');
    }
}
