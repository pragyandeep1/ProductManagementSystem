<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tool extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'category_id',
        'status'
    ];

    public function assetAddress(): HasOne
    {
        return $this->hasOne(AssetAddress::class, 'asset_id')->where('asset_type', 'tools');
    }

    public function assetGeneralInfo(): HasOne
    {
        return $this->hasOne(AssetGeneralInfo::class, 'asset_id')->where('asset_type', 'tools');
    }

    public function assetPartSuppliesLog(): HasMany
    {
        return $this->hasMany(AssetPartSuppliesLog::class, 'asset_id')->where('asset_type', 'tools');
    }

    public function meterReadings(): HasMany
    {
        return $this->hasMany(MeterReadings::class, 'asset_id')->where('asset_type', 'tools');
    }

    public function assetFiles(): HasMany
    {
        return $this->hasMany(AssetFiles::class, 'asset_id')->where('asset_type', 'tools');
    }
    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function facilities(): BelongsTo
    {
        return $this->belongsTo(Facility::class, 'facility_tools_relation', 'tool_id', 'facility_id');
    }
}
