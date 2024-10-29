<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentRelation extends Model
{
    use HasFactory;
    protected $table = 'equipment_relation';
    protected $fillable = [
        'parent_id',
        'child_id'
    ];
}
