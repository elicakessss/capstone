<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AwardType extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
    ];
    public function orgs()
    {
        return $this->belongsToMany(Org::class, 'org_award_type', 'award_type_id', 'org_id');
    }
}
