<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetChargeDepartment extends Model
{
    use HasFactory;
    protected $table = 'asset_charge_department';
    protected $fillable = [
        'code',
        'description',
        'status'
    ];
}
