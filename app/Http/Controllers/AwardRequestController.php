<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AwardRequest;
use App\Models\AwardType;
use App\Models\OrgAwardType;
use App\Models\EvaluationResponse;
use App\Models\AwardRank;

class AwardRequestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'award_type_id' => 'required|exists:award_types,id',
            'org_id' => 'required|exists:orgs,id',
            'is_graduating' => 'accepted',
        ]);
        $user = Auth::user();
        // Check for duplicate request
        $exists = AwardRequest::where('user_id', $user->id)
            ->where('award_type_id', $request->award_type_id)
            ->where('org_id', $request->org_id)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();
        if ($exists) {
            return back()->with('error', 'You have already requested this award.');
        }
        // Find most recent evaluation result for this org and user
        $evaluation = EvaluationResponse::where('user_id', $user->id)
            ->where('org_id', $request->org_id)
            ->latest('created_at')->first();
        $score = $evaluation ? $evaluation->score : null;
        // Find latest org term for this org
        $orgTerm = \App\Models\OrgTerm::where('org_id', $request->org_id)->latest('academic_year')->first();
        if (!$orgTerm) {
            return back()->with('error', 'No org term found for this organization.');
        }
        // Fetch precomputed evaluation result
        $result = \App\Models\EvaluationResult::where('org_term_id', $orgTerm->id)
            ->where('user_id', $user->id)
            ->first();
        $score = $result ? $result->score : null;
        $rank = $result && $result->rank_id ? \App\Models\AwardRank::find($result->rank_id) : null;
        AwardRequest::create([
            'user_id' => $user->id,
            'org_id' => $request->org_id,
            'award_type_id' => $request->award_type_id,
            'status' => 'pending',
            'score' => $score,
            'rank_id' => $rank ? $rank->id : null,
            'is_graduating' => true,
        ]);
        return redirect()->route('portfolio.index')->with('success', 'Award request submitted successfully.');
    }
}
