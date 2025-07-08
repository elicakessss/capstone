<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Council extends Model
{
    use HasFactory;
    protected $fillable = [
        'org_id',
        'academic_year',
        'created_by',
    ];
    public function org()
    {
        return $this->belongsTo(Org::class);
    }
}
