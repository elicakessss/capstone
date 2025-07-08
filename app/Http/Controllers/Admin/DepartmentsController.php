<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentsController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:departments,code',
            'color' => 'nullable|string|max:10',
        ]);

        $department = Department::create([
            'name' => $validated['name'],
            'code' => $validated['code'],
            'color' => $validated['color'] ?? null,
            'is_active' => true,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'department' => $department]);
        }
        return redirect()->back()->with('success', 'Department added successfully.');
    }

    public function show(Department $department)
    {
        return view('admin.orgs.departments.show', compact('department'));
    }

    public function edit(Department $department)
    {
        return view('admin.orgs.departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:departments,code,' . $department->id,
            'color' => 'nullable|string|max:10',
        ]);
        $department->update([
            'name' => $validated['name'],
            'code' => $validated['code'],
            'color' => $validated['color'] ?? null,
        ]);
        return redirect()->route('admin.departments.show', $department)->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('admin.orgs.index')->with('success', 'Department deleted successfully.');
    }
}
