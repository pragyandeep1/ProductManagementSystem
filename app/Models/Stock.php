<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $table = 'stocks';
    protected $fillable = [
        'asset_type',
        'asset_id',
        'parent_id',
        'initial_price',
        'stocks_aisle',
        'stocks_row',
        'stocks_bin',
        'stocks_qty_on_hand',
        'stocks_min_qty',
        'stocks_max_qty',
        'location',
        'quantity',
        'status',
        'submitted_by'
    ];
}
