<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetWarranty extends Model
{
    use HasFactory;
    protected $table = 'asset_warranties';
    protected $fillable = [
        'asset_type',
        'asset_id',
        'warranty_type',
        'provider',
        'warranty_usage_term_type',
        'expiry_date',
        'meter_reading',
        'meter_reading_units',
        'certificate_number',
        'description',
    ];
}
