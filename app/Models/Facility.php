<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Facility extends Model
{
    use HasFactory;

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
        return $this->hasOne(AssetAddress::class, 'asset_id')->where('asset_type', 'facility');
    }

    // Define the relationship with AssetGeneralInfo
    public function assetGeneralInfo(): HasOne
    {
        return $this->hasOne(AssetGeneralInfo::class, 'asset_id')->where('asset_type', 'facility');
    }

    // Define the relationship with AssetPartSuppliesLog
    public function assetPartSuppliesLog(): HasMany
    {
        return $this->hasMany(AssetPartSuppliesLog::class, 'asset_id')->where('asset_type', 'facility');
    }

    // Define the relationship with MeterReadings
    public function meterReadings(): HasMany
    {
        return $this->hasMany(MeterReadings::class, 'asset_id')->where('asset_type', 'facility');
    }

    // Define the relationship with AssetFiles
    public function assetFiles(): HasMany
    {
        return $this->hasMany(AssetFiles::class, 'asset_id')->where('asset_type', 'facility');
    }
    public function equipments(): BelongsToMany
    {
        return $this->belongsToMany(Equipment::class, 'facility_equipment_relation', 'facility_id', 'equipment_id');
    }

    public function tools(): BelongsToMany
    {
        return $this->belongsToMany(Tool::class, 'facility_tools_relation', 'facility_id', 'tool_id');
    }

    public function facilityRelations(): HasMany
    {
        return $this->hasMany(FacilityRelation::class, 'parent_id','child_id');
    }
    public function children(): HasMany
    {
        return $this->hasMany(FacilityRelation::class, 'parent_id','child_id');
    }
    public function childs()
    {
        return $this->hasMany(Facility::class, 'parent_id', 'id');
    }
    public function facilityEquipmentRelations()
    {
        return $this->hasMany(FacilityEquipmentRelation::class);
    }
    public function facilityToolsRelations()
    {
        return $this->hasMany(FacilityToolsRelation::class);
    }
}