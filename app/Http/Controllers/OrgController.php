<?php

namespace App\Http\Controllers;

use App\Models\Org;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;

class OrgController extends Controller
{
    // Admin: List all org templates
    public function indexTemplates()
    {
        // ...
    }

    // Admin: Create org template
    public function createTemplate()
    {
        // ...
    }

    // Admin: Store org template
    public function storeTemplate(Request $request)
    {
        // ...
    }

    // Admin: Assign template to adviser
    public function assignTemplateToAdviser(Request $request)
    {
        // ...
    }

    // Adviser: List assigned templates
    public function indexAssignedTemplates()
    {
        // ...
    }

    // Adviser: Create org instance from template
    public function createInstance($templateId)
    {
        // ...
    }

    // Adviser: Store org instance
    public function storeInstance(Request $request, $templateId)
    {
        // ...
    }

    // Show the organizations index for admin
    public function index()
    {
        $orgs = \App\Models\Org::all();
        $departments = Department::where('is_active', true)->orderBy('name')->get();
        return view('admin.orgs.index', compact('orgs', 'departments'));
    }

    // Store a new organization (admin)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'description' => 'nullable|string',
        ]);

        $org = new Org();
        $org->name = $validated['name'];
        $org->type = $validated['type'];
        $org->department_id = $validated['department_id'];
        $org->description = $validated['description'] ?? null;
        $org->save();

        return redirect()->route('admin.orgs.index')->with('success', 'Organization created successfully.');
    }

    // Show a single organization (admin)
    public function show(Org $org)
    {
        $departments = \App\Models\Department::where('is_active', true)->orderBy('name')->get();
        $positions = $org->positions()->with('departments')->get();
        $advisers = $org->advisers()->get();
        return view('admin.orgs.show', compact('org', 'departments', 'positions', 'advisers'));
    }

    // Edit an organization (admin)
    public function edit(Org $org)
    {
        $departments = Department::where('is_active', true)->orderBy('name')->get();
        return view('admin.orgs.edit', compact('org', 'departments'));
    }

    // Update an organization (admin)
    public function update(Request $request, Org $org)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'description' => 'nullable|string',
        ]);
        $org->update($validated);
        return redirect()->route('admin.orgs.show', $org)->with('success', 'Organization updated successfully.');
    }

    // Delete an organization (admin)
    public function destroy(Org $org)
    {
        $org->delete();
        return redirect()->route('admin.orgs.index')->with('success', 'Organization deleted successfully.');
    }
}
