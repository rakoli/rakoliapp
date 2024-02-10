<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Area extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'country_code',
        'region_code',
        'town_code',
        'name',
        'code',
        'description',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_code', 'code');
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'region_code', 'code');
    }

    public function town(): BelongsTo
    {
        return $this->belongsTo(Towns::class, 'town_code', 'code');
    }

    public function exchange_ads(): HasMany
    {
        return $this->hasMany(ExchangeAds::class, 'area_code', 'code');
    }

    public function locations(): HasMany
    {
        return $this->hasMany(Location::class, 'area_code', 'code');
    }

    public function vas_tasks(): HasMany
    {
        return $this->hasMany(VasTask::class, 'area_code', 'code');
    }
}
