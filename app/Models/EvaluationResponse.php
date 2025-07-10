<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationResponse extends Model
{
    use HasFactory;
    protected $fillable = [
        'org_term_id',
        'user_id',
        'evaluator_id',
        'question_id',
        'score',
    ];
    public function orgTerm() { return $this->belongsTo(OrgTerm::class); }
    public function user() { return $this->belongsTo(User::class, 'user_id'); }
    public function evaluator() { return $this->belongsTo(User::class, 'evaluator_id'); }
    public function question() { return $this->belongsTo(EvaluationQuestion::class); }
}
