<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationQuestion extends Model
{
    use HasFactory;
    protected $fillable = ['strand_id', 'text', 'description', 'order'];

    public function strand() {
        return $this->belongsTo(EvaluationStrand::class, 'strand_id');
    }
    public function likertScales() {
        return $this->hasMany(EvaluationLikertScale::class, 'question_id');
    }
    public function evaluatorTypes() {
        return $this->hasMany(EvaluationQuestionEvaluatorType::class, 'question_id');
    }
}
