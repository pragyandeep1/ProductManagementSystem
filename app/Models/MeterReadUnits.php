<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeterReadUnits extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'unit_precision',
        'symbol',
        'status'
    ];
}
