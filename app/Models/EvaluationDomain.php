<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationDomain extends Model
{
    use HasFactory;
    protected $fillable = ['form_id', 'name', 'description', 'order'];

    public function form() {
        return $this->belongsTo(EvaluationForm::class, 'form_id');
    }
    public function strands() {
        return $this->hasMany(EvaluationStrand::class, 'domain_id');
    }
}
