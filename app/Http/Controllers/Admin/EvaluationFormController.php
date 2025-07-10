<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EvaluationForm;
use App\Models\Org;
use Illuminate\Http\Request;

class EvaluationFormController extends Controller
{
    public function index()
    {
        $forms = EvaluationForm::all();
        return view('admin.forms.index', compact('forms'));
    }

    public function show(EvaluationForm $form)
    {
        $organizations = Org::orderBy('name')->get();
        $form->load('organizations');
        return view('admin.forms.show', compact('form', 'organizations'));
    }

    public function store(Request $request)
    {
        $form = EvaluationForm::create($request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]) + ['created_by' => auth()->id()]);
        return redirect()->route('admin.forms.show', $form);
    }

    public function assignOrgs(Request $request, EvaluationForm $form)
    {
        $orgIds = $request->input('organization_ids', []);
        $form->organizations()->sync($orgIds);
        return redirect()->route('admin.forms.show', $form)->with('success', 'Organizations assigned successfully.');
    }

    public function destroy(EvaluationForm $form)
    {
        $form->delete();
        return redirect()->route('admin.forms.index')->with('success', 'Form deleted.');
    }

    public function updateCriteriaWeights(Request $request, EvaluationForm $form)
    {
        $weights = $request->input('weights', []);
        $requiredTypes = ['Adviser', 'Peer', 'Self', 'LengthOfService'];
        $total = 0;
        foreach ($requiredTypes as $type) {
            $total += isset($weights[$type]) ? floatval($weights[$type]) : 0;
        }
        if ($total !== 100.0) {
            return redirect()->back()->withErrors(['weights' => 'Total weight must be 100%.']);
        }
        foreach ($requiredTypes as $type) {
            $form->criteriaWeights()->updateOrCreate(
                ['evaluator_type' => $type],
                ['weight' => $weights[$type] ?? 0]
            );
        }
        return redirect()->route('admin.forms.show', $form)->with('success', 'Criteria weights updated successfully.');
    }
}
