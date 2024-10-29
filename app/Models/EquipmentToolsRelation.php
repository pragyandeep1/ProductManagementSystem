<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentToolsRelation extends Model
{
    use HasFactory;
    protected $table = 'equipment_tools_relation';
    protected $fillable = [
        'equipment_id',
        'tool_id'
    ];
}
