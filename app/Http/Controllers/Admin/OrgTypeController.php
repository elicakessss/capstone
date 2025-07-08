<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrgType;

class OrgTypeController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:org_types,name',
            'description' => 'nullable|string',
        ]);
        $orgType = OrgType::create($validated);
        if ($request->ajax()) {
            return response()->json(['success' => true, 'orgType' => $orgType]);
        }
        return redirect()->back()->with('success', 'Org Type added successfully.');
    }

    public function show($type)
    {
        $type = \App\Models\OrgType::findOrFail($type);
        $orgs = \App\Models\Org::where('type', $type->name)->get();
        return view('admin.orgs.types.show', compact('type', 'orgs'));
    }

    public function update(Request $request, $type)
    {
        $orgType = OrgType::findOrFail($type);
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:org_types,name,' . $orgType->id,
            'description' => 'nullable|string',
        ]);
        $orgType->update($validated);
        if ($request->ajax()) {
            return response()->json(['success' => true, 'orgType' => $orgType]);
        }
        return redirect()->route('admin.org_types.show', $orgType)->with('success', 'Org Type updated successfully.');
    }

    public function destroy(OrgType $type)
    {
        $type->delete();
        // Redirect to the main orgs index, since there is no admin.org_types.index route
        return redirect()->route('admin.orgs.index')->with('success', 'Org type deleted successfully.');
    }
}
