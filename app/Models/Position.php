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
        'description',
        'slots',
        'order',
    ];

    public function org()
    {
        return $this->belongsTo(Org::class);
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'department_position');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'position_user', 'position_id', 'user_id');
    }
}
