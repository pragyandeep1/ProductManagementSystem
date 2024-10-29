<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilityToolsRelation extends Model
{
    use HasFactory;
    protected $table = 'facility_tools_relation';
    protected $fillable = [
        'facility_id',
        'tool_id'
    ];
}
