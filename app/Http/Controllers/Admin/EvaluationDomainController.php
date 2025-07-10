<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EvaluationForm;
use App\Models\EvaluationDomain;
use Illuminate\Http\Request;

class EvaluationDomainController extends Controller
{
    public function store(Request $request, EvaluationForm $form)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $form->domains()->create([
            'name' => $request->name,
            'description' => $request->description,
            'order' => $form->domains()->count() + 1,
        ]);
        return redirect()->route('admin.forms.show', $form)->with('success', 'Domain added.');
    }

    public function update(Request $request, EvaluationForm $form, EvaluationDomain $domain)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $domain->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return redirect()->route('admin.forms.show', $form)->with('success', 'Domain updated.');
    }
}
