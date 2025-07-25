<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AwardRank extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'min_score',
        'max_score',
        'order',
    ];
}
