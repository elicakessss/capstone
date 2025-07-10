<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AwardRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'org_id',
        'award_type_id',
        'status',
        'score',
        'rank_id',
        'is_graduating',
    ];
    public function user() { return $this->belongsTo(User::class); }
    public function org() { return $this->belongsTo(Org::class); }
    public function awardType() { return $this->belongsTo(AwardType::class); }
    public function rank() { return $this->belongsTo(AwardRank::class, 'rank_id'); }
}
