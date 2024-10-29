<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetAccounts extends Model
{
    use HasFactory;
    protected $table = 'asset_account';
    protected $fillable = [
        'code',
        'description',
        'status'
    ];
}
