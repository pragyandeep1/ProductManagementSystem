<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetFiles extends Model
{
    use HasFactory;
    protected $table = 'asset_files';
    protected $primaryKey = 'af_id';
    protected $fillable = [
        'name',
        'asset_type',
        'asset_id',
        'type',
        'url',
    ];
}
