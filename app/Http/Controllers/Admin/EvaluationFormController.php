<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EvaluationForm;
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
        return view('admin.forms.show', compact('form'));
    }

    public function store(Request $request)
    {
        $form = EvaluationForm::create($request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]) + ['created_by' => auth()->id()]);
        return redirect()->route('admin.forms.show', $form);
    }

    public function destroy(EvaluationForm $form)
    {
        $form->delete();
        return redirect()->route('admin.forms.index')->with('success', 'Form deleted.');
    }
}
