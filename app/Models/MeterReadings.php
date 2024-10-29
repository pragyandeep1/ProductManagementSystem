<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeterReadings extends Model
{
    use HasFactory;
    protected $table = 'meter_readings';
    protected $fillable = [
        'asset_type',
        'asset_id',
        'reading_value',
        'meter_units_id',
        'submitted_by'
    ];
}
