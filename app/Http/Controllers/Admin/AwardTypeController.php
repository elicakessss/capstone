<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AwardType;

class AwardTypeController extends Controller
{
    public function index()
    {
        $awardTypes = AwardType::orderBy('name')->get();
        // For now, no requests logic here
        $awardRequests = [];
        return view('admin.awards.index', compact('awardTypes', 'awardRequests'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);
        AwardType::create($data);
        return redirect()->route('admin.award-types.index')->with('success', 'Award type created.');
    }

    public function update(Request $request, $id)
    {
        $awardType = AwardType::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);
        $awardType->update($data);
        return redirect()->route('admin.award-types.index')->with('success', 'Award type updated.');
    }

    public function destroy($id)
    {
        $awardType = AwardType::findOrFail($id);
        $awardType->delete();
        return redirect()->route('admin.award-types.index')->with('success', 'Award type deleted.');
    }
}
