<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipment extends Model
{
    use HasFactory;
    protected $table = 'equipments';
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
        return $this->hasOne(AssetAddress::class, 'asset_id')->where('asset_type', 'equipment');
    }

    // Define the relationship with AssetGeneralInfo
    public function assetGeneralInfo(): HasOne
    {
        return $this->hasOne(AssetGeneralInfo::class, 'asset_id')->where('asset_type', 'equipment');
    }

    // Define the relationship with AssetPartSuppliesLog
    public function assetPartSuppliesLog(): HasMany
    {
        return $this->hasMany(AssetPartSuppliesLog::class, 'asset_id')->where('asset_type', 'equipment');
    }

    // Define the relationship with MeterReadings
    public function meterReadings(): HasMany
    {
        return $this->hasMany(MeterReadings::class, 'asset_id')->where('asset_type', 'equipment');
    }

    // Define the relationship with AssetFiles
    public function assetFiles(): HasMany
    {
        return $this->hasMany(AssetFiles::class, 'asset_id')->where('asset_type', 'equipment');
    }
    public function facilities(): BelongsTo
    {
        return $this->belongsTo(Facility::class, 'facility_equipment_relation', 'equipment_id', 'facility_id');
    }

    public function tools(): HasMany
    {
        return $this->hasMany(Tool::class, 'equipment_tools_relation', 'equipment_id', 'tool_id');
    }

    public function equipmentRelation(): HasMany
    {
        return $this->hasMany(EquipmentRelation::class, 'parent_id');
    }
}