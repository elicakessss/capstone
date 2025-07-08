<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationStrand extends Model
{
    use HasFactory;
    protected $fillable = ['domain_id', 'name', 'order'];

    public function domain() {
        return $this->belongsTo(EvaluationDomain::class, 'domain_id');
    }
    public function questions() {
        return $this->hasMany(EvaluationQuestion::class, 'strand_id');
    }
}
