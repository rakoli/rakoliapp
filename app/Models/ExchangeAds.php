<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExchangeAds extends Model
{
    use HasFactory;

    public function area() : BelongsTo
    {
        return $this->belongsTo(Area::class, 'area_code', 'code');
    }

    public function business() : BelongsTo
    {
        return $this->belongsTo(Business::class, 'business_code', 'code');
    }

    public function country() : BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_code', 'code');
    }

    public function location() : BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_code', 'code');
    }

    public function region() : BelongsTo
    {
        return $this->belongsTo(Region::class, 'region_code', 'code');
    }

    public function town() : BelongsTo
    {
        return $this->belongsTo(Towns::class, 'town_code', 'code');
    }

    public function exchange_chats() : HasMany
    {
        return $this->hasMany(ExchangeChat::class, 'exchange_ads_code', 'code');
    }

    public function exchange_transactions(): HasMany
    {
        return $this->hasMany(ExchangeTransaction::class, 'exchange_ads_code', 'code');
    }

    public function exchange_payment_methods()
    {
        return $this->hasMany(ExchangePaymentMethod::class,'exchange_ads_code','code');
    }
}
