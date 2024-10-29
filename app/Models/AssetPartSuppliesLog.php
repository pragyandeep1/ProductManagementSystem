<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetPartSuppliesLog extends Model
{
    use HasFactory;
    protected $table = 'asset_part_supplies_log';
    protected $fillable = [
        'asset_type',
        'asset_source',
        'asset_id',
        'part_supply_id',
        'quantity',
        'submitted_by',
    ];
}