<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeAds extends Model
{
    use HasFactory;

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_code', 'code');
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_code', 'code');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_code', 'code');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_code', 'code');
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_code', 'code');
    }

    public function town()
    {
        return $this->belongsTo(Towns::class, 'town_code', 'code');
    }

    public function ads_exchange_chats()
    {
        return $this->hasMany(AdsExchangeChat::class, 'exchange_ads_code', 'code');
    }

    public function exchange_transactions()
    {
        return $this->hasMany(ExchangeTransaction::class, 'exchange_ads_code', 'code');
    }
}
