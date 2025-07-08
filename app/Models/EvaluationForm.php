<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationForm extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'created_by'];

    public function domains() {
        return $this->hasMany(EvaluationDomain::class, 'form_id');
    }
    public function criteriaWeights() {
        return $this->hasMany(EvaluationCriteriaWeight::class, 'form_id');
    }
    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
