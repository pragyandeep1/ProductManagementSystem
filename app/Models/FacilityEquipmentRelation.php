<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilityEquipmentRelation extends Model
{
    use HasFactory;
    protected $table = 'facility_equipment_relation';
    protected $fillable = [
        'facility_id',
        'equipment_id'
    ];
}
