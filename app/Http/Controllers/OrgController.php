<?php

namespace App\Http\Controllers;

use App\Models\Org;
use App\Models\User;
use App\Models\Department;
use App\Models\OrgType;
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
        $user = auth()->user();
        $assignedTemplates = $user->advisedOrgs()->whereNull('template_id')->with('department')->get();
        return view('adviser.orgs.assigned-templates.index', compact('assignedTemplates'));
    }

    // Adviser: Create org instance from template
    public function createInstance($templateId)
    {
        $template = Org::with('positions')->findOrFail($templateId);
        return view('adviser.orgs.instances.create', compact('template'));
    }

    // Adviser: Store org instance
    public function storeInstance(Request $request, $templateId)
    {
        $request->validate([
            'academic_year' => 'required|string|max:20',
        ]);
        $template = Org::with('positions')->findOrFail($templateId);
        $user = auth()->user();
        // Create new org instance
        $instance = Org::create([
            'name' => $template->name,
            'type' => $template->type,
            'description' => $template->description,
            'department_id' => $template->department_id,
            'template_id' => $template->id,
            'adviser_id' => $user->id,
            'term' => $request->academic_year,
            'is_active' => true,
            'created_by' => $template->created_by,
        ]);
        // Copy positions from template
        foreach ($template->positions as $position) {
            $instance->positions()->create([
                'title' => $position->title,
            ]);
        }
        return redirect()->route('adviser.organizations')->with('success', 'Organization instance created for academic year ' . $request->academic_year);
    }

    // Show the organizations index for admin
    public function index()
    {
        $orgs = \App\Models\Org::all();
        $departments = Department::where('is_active', true)->orderBy('name')->get();
        $orgTypes = OrgType::orderBy('name')->get();
        return view('admin.orgs.index', compact('orgs', 'departments', 'orgTypes'));
    }

    // Store a new organization (admin)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:2048', // Add logo validation
        ]);

        $org = new Org();
        $org->name = $validated['name'];
        $org->type = $validated['type'];
        $org->department_id = $validated['department_id'] ?? null;
        $org->description = $validated['description'] ?? null;

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoPath = $logo->store('org_logos', 'public');
            $org->logo = $logoPath;
        }

        $org->save();

        return redirect()->route('admin.orgs.index')->with('success', 'Organization created successfully.');
    }

    // Show a single organization (admin)
    public function show(Org $org)
    {
        $departments = \App\Models\Department::where('is_active', true)->orderBy('name')->get();
        $positions = $org->positions()->with('departments')->get();
        $advisers = $org->advisers()->get();
        $orgTypes = \App\Models\OrgType::orderBy('name')->get();
        return view('admin.orgs.show', compact('org', 'departments', 'positions', 'advisers', 'orgTypes'));
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
            'logo' => 'nullable|image|max:2048', // Add logo validation
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoPath = $logo->store('org_logos', 'public');
            // Delete old logo if exists
            if ($org->logo && \Storage::disk('public')->exists($org->logo)) {
                \Storage::disk('public')->delete($org->logo);
            }
            $org->logo = $logoPath;
        }

        $org->name = $validated['name'];
        $org->type = $validated['type'];
        $org->department_id = $validated['department_id'];
        $org->description = $validated['description'] ?? null;
        $org->save();

        return redirect()->route('admin.orgs.show', $org)->with('success', 'Organization updated successfully.');
    }

    // Delete an organization (admin)
    public function destroy(Org $org)
    {
        $org->delete();
        return redirect()->route('admin.orgs.index')->with('success', 'Organization deleted successfully.');
    }

    // Adviser: List created org instances and available templates
    public function indexInstances()
    {
        $user = auth()->user();
        // All orgs this adviser has instantiated (instances, not templates)
        $orgInstances = Org::where('adviser_id', $user->id)->whereNotNull('template_id')->with('department')->get();
        // All templates this adviser can use (assigned, not yet instantiated for any year)
        $assignedTemplates = $user->advisedOrgs()->whereNull('template_id')->get();
        // Only show templates not already instantiated for any year by this adviser
        $usedTemplateIds = $orgInstances->pluck('template_id')->unique();
        $availableTemplates = $assignedTemplates->whereNotIn('id', $usedTemplateIds);
        return view('adviser.orgs.instances.index', compact('orgInstances', 'availableTemplates'));
    }

    // Adviser: Assign student to position (enforce one position per org)
    public function assignStudentToPosition(Request $request, $orgId, $positionId)
    {
        $org = Org::findOrFail($orgId);
        $position = $org->positions()->findOrFail($positionId);
        $studentId = $request->input('student_id');
        $student = \App\Models\User::findOrFail($studentId);

        // Enforce department logic
        if ($org->department_id) {
            if ($student->department_id != $org->department_id) {
                return response()->json(['success' => false, 'message' => 'Student does not belong to the required department.'], 403);
            }
        }
        // If org->department_id is null, allow any student
        $position->users()->attach($studentId);
        return response()->json(['success' => true]);
    }
}
