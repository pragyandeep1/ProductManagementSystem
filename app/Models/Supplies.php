<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Supplies extends Model
{
    use HasFactory;
    protected $table = 'supplies';
    protected $fillable = [
        'name',
        'code',
        'description',
        'category_id',
        'status'
    ];
    // Define the relationship with AssetAddress
    public function assetAddress(): HasOne
    {
        return $this->hasOne(AssetAddress::class, 'asset_id')->where('asset_type', 'supply');
    }

    // Define the relationship with AssetGeneralInfo
    public function assetGeneralInfo(): HasOne
    {
        return $this->hasOne(AssetGeneralInfo::class, 'asset_id')->where('asset_type', 'supply');
    }

    // Define the relationship with AssetPartSuppliesLog
    public function assetPartSuppliesLog(): HasMany
    {
        return $this->hasMany(AssetPartSuppliesLog::class, 'part_supply_id')
            ->whereIn('asset_type', ['supply', 'facility', 'equipment', 'tools']);
    }


    // Define the relationship with MeterReadings
    public function meterReadings(): HasMany
    {
        return $this->hasMany(MeterReadings::class, 'asset_id')->where('asset_type', 'supply');
    }

    // Define the relationship with AssetFiles
    public function assetFiles(): HasMany
    {
        return $this->hasMany(AssetFiles::class, 'asset_id')->where('asset_type', 'supply');
    }
    // Define the relationship with Stocks
    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class, 'asset_id')->where('asset_type', 'supply');
    }
    public function inventories(): HasMany
    {
        return $this->hasMany(AssetInventory::class, 'asset_id')->where('asset_type', 'supply');
    }
    public function assetWarranty(): HasMany
    {
        return $this->hasMany(AssetWarranty::class, 'asset_id')->where('asset_type', 'supply');
    }
    public function assetUser(): HasMany
    {
        return $this->hasMany(AssetUser::class, 'asset_id')->where('asset_type', 'supply');
    }
}