<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationCriteriaWeight extends Model
{
    use HasFactory;
    protected $fillable = ['form_id', 'evaluator_type', 'weight'];

    public function form() {
        return $this->belongsTo(EvaluationForm::class, 'form_id');
    }
}
