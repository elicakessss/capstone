<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EvaluationForm;
use App\Models\EvaluationDomain;
use Illuminate\Http\Request;

class EvaluationStrandController extends Controller
{
    public function store(Request $request, EvaluationForm $form, EvaluationDomain $domain)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $domain->strands()->create([
            'name' => $request->name,
            'order' => $domain->strands()->count() + 1,
        ]);
        return redirect()->route('admin.forms.show', $form)->with('success', 'Strand added.');
    }

    public function update(Request $request, EvaluationForm $form, EvaluationDomain $domain, $strandId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $strand = $domain->strands()->findOrFail($strandId);
        $strand->update([
            'name' => $request->name,
        ]);
        return redirect()->route('admin.forms.show', $form)->with('success', 'Strand updated.');
    }
}
