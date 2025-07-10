<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationResult extends Model
{
    use HasFactory;
    protected $fillable = [
        'org_term_id',
        'user_id',
        'score',
        'rank_id',
    ];
    public function orgTerm() { return $this->belongsTo(OrgTerm::class); }
    public function user() { return $this->belongsTo(User::class); }
    public function rank() { return $this->belongsTo(AwardRank::class, 'rank_id'); }
}
