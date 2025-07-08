<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EvaluationForm;
use App\Models\EvaluationDomain;
use App\Models\EvaluationStrand;
use Illuminate\Http\Request;

class EvaluationQuestionController extends Controller
{
    public function store(Request $request, EvaluationForm $form, EvaluationDomain $domain, EvaluationStrand $strand)
    {
        $request->validate([
            'text' => 'required|string|max:255',
            'likert_labels' => 'required|array|min:1',
            'likert_scores' => 'required|array|min:1',
            'evaluator_types' => 'required|array|min:1',
        ]);
        $question = $strand->questions()->create([
            'text' => $request->text,
            'order' => $strand->questions()->count() + 1,
        ]);
        // Save Likert scale options
        foreach (array_map(null, $request->likert_labels, $request->likert_scores) as $i => [$label, $score]) {
            $question->likertScales()->create([
                'label' => $label,
                'score' => $score,
                'order' => $i + 1,
            ]);
        }
        // Save evaluator types
        foreach ($request->evaluator_types as $type) {
            $question->evaluatorTypes()->create([
                'evaluator_type' => $type,
            ]);
        }
        return redirect()->route('admin.forms.show', $form)->with('success', 'Question added.');
    }
}
