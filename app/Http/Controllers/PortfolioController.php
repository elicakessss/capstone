<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\OrgTerm;
use App\Models\Position;
use App\Http\Controllers\AwardController;
use App\Models\Award;

class PortfolioController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Get all org terms where the user is assigned to a position
        $orgTerms = OrgTerm::whereHas('org.positions.users', function($q) use ($user) {
            $q->where('users.id', $user->id);
        })->with(['org', 'org.positions' => function($q) use ($user) {
            $q->whereHas('users', function($q2) use ($user) {
                $q2->where('users.id', $user->id);
            });
        }, 'org.positions.users' => function($q) use ($user) {
            $q->where('users.id', $user->id);
        }])->get();

        // For the left card: org/position pairs for this user (student or adviser)
        $orgPositions = [];
        $uniqueKeys = [];
        // Member positions (use org_term_user for accuracy)
        foreach ($orgTerms as $orgTerm) {
            $pivotRows = \DB::table('org_term_user')
                ->where('org_term_id', $orgTerm->id)
                ->where('user_id', $user->id)
                ->get();
            foreach ($pivotRows as $pivot) {
                $position = Position::find($pivot->position_id);
                if ($position) {
                    $key = $orgTerm->org->id . '|' . $orgTerm->academic_year . '|' . $position->title;
                    if (!isset($uniqueKeys[$key])) {
                        $orgPositions[] = [
                            'org' => $orgTerm->org->name,
                            'academic_year' => $orgTerm->academic_year,
                            'role' => $position->title,
                            'logo' => $orgTerm->org->logo ?? null,
                        ];
                        $uniqueKeys[$key] = true;
                    }
                }
            }
        }
        // Adviser orgs: add orgs where user is an adviser
        if (in_array('adviser', $user->roles ?? [])) {
            $advisedOrgs = $user->advisedOrgs ? $user->advisedOrgs()->with('orgTerms')->get() : collect();
            foreach ($advisedOrgs as $org) {
                $advisedTerms = $org->orgTerms ?? collect();
                foreach ($advisedTerms as $term) {
                    $key = $org->id . '|' . $term->academic_year . '|Adviser';
                    if (!isset($uniqueKeys[$key])) {
                        $orgPositions[] = [
                            'org' => $org->name,
                            'academic_year' => $term->academic_year,
                            'role' => 'Adviser',
                            'logo' => $org->logo ?? null,
                        ];
                        $uniqueKeys[$key] = true;
                    }
                }
            }
        }

        // Certificates: list files in storage/app/certificates/{user_id}/
        $certificates = [];
        $certDir = 'certificates/' . $user->id;
        if (Storage::exists($certDir)) {
            $certificates = collect(Storage::files($certDir))->map(function($file) {
                return basename($file);
            });
        }

        // Awards: fetch from DB
        $awards = Award::where('user_id', $user->id)->latest()->get();

        return view('portfolio.index', compact('orgTerms', 'orgPositions', 'certificates', 'awards'));
    }

    public function uploadCertificate(Request $request)
    {
        $request->validate([
            'certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);
        $user = Auth::user();
        $path = $request->file('certificate')->store('certificates/' . $user->id);
        return redirect()->route('portfolio.index')->with('success', 'Certificate uploaded successfully.');
    }
}
