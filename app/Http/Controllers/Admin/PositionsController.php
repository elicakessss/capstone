<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionsController extends Controller
{
    // Show edit form (optional, for Blade UI)
    public function edit(Position $position)
    {
        return view('admin.positions.edit', compact('position'));
    }

    // Update a position
    public function update(Request $request, Position $position)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'nullable|string',
            'slots' => 'required|integer|min:1',
            'order' => 'required|integer|min:1|unique:positions,order,' . $position->id,
        ]);
        $position->update($validated);
        // Sync departments if present
        if ($request->has('departments')) {
            $position->departments()->sync($request->input('departments'));
        }
        return redirect()->back()->with('success', 'Position updated successfully.');
    }

    // Delete a position
    public function destroy(Position $position)
    {
        $position->delete();
        return redirect()->back()->with('success', 'Position deleted successfully.');
    }
}
