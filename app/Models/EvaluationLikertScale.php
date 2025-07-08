<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationLikertScale extends Model
{
    use HasFactory;
    protected $fillable = ['question_id', 'label', 'score', 'order'];

    public function question() {
        return $this->belongsTo(EvaluationQuestion::class, 'question_id');
    }
}
