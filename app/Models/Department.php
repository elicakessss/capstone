<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'is_active',
        'color',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the users that belong to this department.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the organization types that belong to this department.
     */
    public function orgTypes()
    {
        return $this->hasMany(OrgType::class, 'department_id');
    }
}
