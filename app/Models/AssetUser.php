<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetUser extends Model
{
    use HasFactory;
    protected $table = 'asset_users';
    protected $fillable = [
        'asset_type',
        'asset_id',
        'user_id',
    ];
}
