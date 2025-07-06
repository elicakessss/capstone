<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $fillable = [
        'org_id',
        'title',
    ];

    public function org()
    {
        return $this->belongsTo(Org::class);
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'department_position');
    }
}
