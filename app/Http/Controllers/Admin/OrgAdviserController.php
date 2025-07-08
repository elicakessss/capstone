<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Org;
use App\Models\User;
use Illuminate\Http\Request;

class OrgAdviserController extends Controller
{
    // Search advisers (AJAX)
    public function search(Request $request, Org $org)
    {
        $q = $request->input('q');
        $advisers = User::whereJsonContains('roles', 'adviser')
            ->where(function($query) use ($q) {
                $query->where('name', 'like', "%$q%")
                      ->orWhere('email', 'like', "%$q%") ;
            })
            ->limit(10)
            ->get(['id', 'name', 'email']);
        return response()->json($advisers);
    }

    // Assign adviser to org
    public function assign(Request $request, Org $org)
    {
        $validated = $request->validate([
            'adviser_id' => 'required|exists:users,id',
        ]);
        // Attach adviser to org (many-to-many)
        $org->advisers()->syncWithoutDetaching([$validated['adviser_id']]);
        return redirect()->back()->with('success', 'Adviser assigned successfully.');
    }
}
