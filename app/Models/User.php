<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id_number',
        'first_name',
        'last_name',
        'name',
        'email',
        'password',
        'role',
        'roles', // Add roles to fillable
        'department_id',
        'profile_picture',
        'bio',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'roles' => 'array', // Cast roles as array
        ];
    }

    /**
     * Get the user's full name.
     */
    public function getNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the department that the user belongs to.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Orgs created by this user (as admin)
     */
    public function createdOrgs()
    {
        return $this->hasMany(Org::class, 'created_by');
    }

    /**
     * Orgs assigned to this user (as adviser)
     */
    public function advisedOrgs()
    {
        return $this->belongsToMany(Org::class, 'org_adviser', 'adviser_id', 'org_id');
    }
}
