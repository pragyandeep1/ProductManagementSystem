<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Business extends Model
{
    use HasFactory;
    protected $table = 'businesses';
    protected $fillable = [
        'name',
        'code',
        'contact',
        'location',
        'currency',
        'business_classification',
        'description',
        'status'
    ];
    // Define the relationship with AssetFiles
    public function assetFiles(): HasMany
    {
        return $this->hasMany(AssetFiles::class, 'asset_id')->where('asset_type', 'business');
    }
    public function assetUser(): HasMany
    {
        return $this->hasMany(AssetUser::class, 'asset_id')->where('asset_type', 'business');
    }
}
