<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetAddress extends Model
{
    use HasFactory;
    protected $table = 'asset_address';
    protected $fillable = [
        'asset_type',
        'asset_id',
        'has_parent',
        'parent_id',
        'aisle',
        'row',
        'bin',
        'address',
    ];
}
