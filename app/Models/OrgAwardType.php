<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrgAwardType extends Model
{
    use HasFactory;
    protected $table = 'org_award_type';
    protected $fillable = [
        'org_id',
        'award_type_id',
    ];
}
