<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrgTerm;

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

        return view('orgs.org_terms.show', compact('orgTerm', 'advisers', 'positions', 'isAdviserOrAdmin'));
    }

    public function assignStudent(Request $request, $orgTermId)
    {
        $request->validate([
            'position_id' => 'required|exists:positions,id',
            'student_id' => 'required|exists:users,id',
        ]);

        $orgTerm = \App\Models\OrgTerm::with('org.positions')->findOrFail($orgTermId);
        $position = $orgTerm->org->positions->where('id', $request->position_id)->first();
        if (!$position) {
            return back()->withErrors(['position_id' => 'Invalid position for this organization term.']);
        }
        // Attach student to position if not already assigned
        if (!$position->users->contains($request->student_id)) {
            $position->users()->attach($request->student_id);
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
}
