<?php

namespace App\Models;

use App\Models\Scopes\BusinessScoped;
use App\Models\Scopes\LocationScoped;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::addGlobalScope(new BusinessScoped);
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class, 'Business_Code', 'Business_Code');
    }

    public function networks(): HasMany
    {
        return $this->hasMany(Network::class, 'location_code', 'code');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'location_users',
            'location_code',
            'user_code',
            'code',
            'code'
        );
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'area_code', 'code');
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'region_code', 'code');
    }

    public function town(): BelongsTo
    {
        return $this->belongsTo(Towns::class, 'town_code', 'code');
    }

    public function exchange_ads() : HasMany
    {
        return $this->hasMany(ExchangeAds::class, 'location_code', 'code');
    }

    public function loans() : HasMany
    {
        return $this->hasMany(Loan::class, 'location_code', 'code');
    }

    public function shift_networks() : HasMany
    {
        return $this->hasMany(ShiftNetwork::class, 'location_code', 'code');
    }

    public function shift_transactions() : HasMany
    {
        return $this->hasMany(ShiftTransaction::class, 'location_code', 'code');
    }

    public function shifts() : HasMany
    {
        return $this->hasMany(Shift::class, 'location_code', 'code');
    }

    public function shorts() : HasMany
    {
        return $this->hasMany(Short::class, 'location_code', 'code');
    }

    public function transactions() : HasMany
    {
        return $this->hasMany(Transaction::class, 'location_code', 'code');
    }
}
