<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationQuestionEvaluatorType extends Model
{
    use HasFactory;
    protected $fillable = ['question_id', 'evaluator_type'];

    public function question() {
        return $this->belongsTo(EvaluationQuestion::class, 'question_id');
    }
}
