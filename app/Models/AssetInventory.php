<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetInventory extends Model
{
    use HasFactory;
    protected $table = 'inventories';
    protected $fillable = [
        'asset_type',
        'asset_id',
        'purchased_from',
        'purchase_currency',
        'date_ordered',
        'date_received',
        'parent_id',
        'quantity_received',
        'purchase_price_per_unit',
        'purchase_price_total',
        'date_of_expiry',
        'status',
    ];
}
