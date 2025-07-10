<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrgTerm extends Model
{
    use HasFactory;
    protected $table = 'org_terms';
    protected $fillable = [
        'org_id',
        'academic_year',
        'created_by',
        'evaluation_state',
    ];
    public function org()
    {
        return $this->belongsTo(Org::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'org_term_user', 'org_term_id', 'user_id')->withPivot('terms_served');
    }
}
