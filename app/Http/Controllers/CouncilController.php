<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Council;

class CouncilController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $assignedOrgs = [];
        if ($user && ($user->role === 'adviser' || $user->role === 'admin')) {
            // For admin, show all orgs; for adviser, show only assigned orgs
            if ($user->role === 'admin') {
                $assignedOrgs = \App\Models\Org::all();
            } else {
                $assignedOrgs = $user->advisedOrgs ? $user->advisedOrgs()->get() : [];
            }
        }
        // Councils (org terms) the user is a member of (participated)
        $participatedCouncils = Council::whereHas('org.positions.users', function($q) use ($user) {
            $q->where('users.id', $user->id);
        })->with('org')->get();
        // Councils (org terms) the user created
        $createdCouncils = Council::where('created_by', $user->id)->with('org')->get();
        return view('orgs.index', compact('assignedOrgs', 'participatedCouncils', 'createdCouncils'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'org_id' => 'required|exists:orgs,id',
            'academic_year' => 'required|string|max:20',
        ]);
        // Prevent duplicate org+year
        if (\App\Models\Council::where('org_id', $validated['org_id'])->where('academic_year', $validated['academic_year'])->exists()) {
            return back()->withErrors(['academic_year' => 'This organization already exists for the selected academic year.'])->withInput();
        }
        $council = new \App\Models\Council();
        $council->org_id = $validated['org_id'];
        $council->academic_year = $validated['academic_year'];
        $council->created_by = auth()->id();
        $council->save();
        return redirect()->route('orgs.index')->with('success', 'Organization term created successfully.');
    }

    public function checkDuplicate(Request $request)
    {
        $orgId = $request->query('org_id');
        $year = $request->query('academic_year');
        $exists = false;
        if ($orgId && $year) {
            $exists = Council::where('org_id', $orgId)
                ->where('academic_year', $year)
                ->exists();
        }
        return response()->json(['exists' => $exists]);
    }
}
