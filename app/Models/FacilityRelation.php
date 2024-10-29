<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilityRelation extends Model
{
    use HasFactory;
    protected $table = 'facility_relation';
    protected $fillable = [
        'parent_id',
        'child_id'
    ];
}
