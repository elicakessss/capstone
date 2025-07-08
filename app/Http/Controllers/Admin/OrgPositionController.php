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
            'slots' => 'required|integer|min:1',
            'order' => 'required|integer|min:1|unique:positions,order',
            'departments' => 'required|array',
            'departments.*' => 'exists:departments,id',
        ]);

        $position = $org->positions()->create([
            'title' => $validated['title'],
            'slots' => $validated['slots'],
            'order' => $validated['order'],
        ]);
        $position->departments()->sync($validated['departments']);

        return redirect()->back()->with('success', 'Position added successfully.');
    }
}
