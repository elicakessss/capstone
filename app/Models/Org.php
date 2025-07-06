<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Org extends Model
{
    use HasFactory;

    protected $table = 'orgs';

    protected $fillable = [
        'name',
        'type',
        'logo',
        'description',
        'term',
        'is_active',
        'created_by',
        'template_id',
        'adviser_id',
        'evaluation_deadline',
        'is_evaluated',
        'department_id',
    ];

    // Creator (admin)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Adviser (nullable)
    public function adviser()
    {
        return $this->belongsTo(User::class, 'adviser_id');
    }

    // Template (nullable, self-referencing)
    public function template()
    {
        return $this->belongsTo(Org::class, 'template_id');
    }

    // Instances (orgs created from this template)
    public function instances()
    {
        return $this->hasMany(Org::class, 'template_id');
    }

    // Department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Positions
    public function positions()
    {
        return $this->hasMany(Position::class);
    }

    // Advisers (many-to-many relationship)
    public function advisers()
    {
        return $this->belongsToMany(User::class, 'org_adviser', 'org_id', 'adviser_id');
    }
}
