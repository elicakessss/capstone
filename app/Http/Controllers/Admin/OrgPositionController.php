<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Org;
use App\Models\Position;
use Illuminate\Http\Request;

class OrgPositionController extends Controller
{
    public function store(Request $request, Org $org)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'departments' => 'required|array',
            'departments.*' => 'exists:departments,id',
        ]);

        $position = $org->positions()->create([
            'title' => $validated['title'],
        ]);
        $position->departments()->sync($validated['departments']);

        return redirect()->back()->with('success', 'Position added successfully.');
    }
}
