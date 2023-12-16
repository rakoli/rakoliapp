<?php

namespace App\Models;

use App\Utils\Enums\ExchangeStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ExchangeAds extends Model
{
    use HasFactory;

    protected $appends = ['completion','feedback','trades'];

    protected $fillable = [
        'country_code',
        'business_code',
        'location_code',
        'code',
        'min_amount',
        'max_amount',
        'currency',
        'status',
        'description',
        'availability_desc',
        'terms',
        'open_note',
        'region_code',
        'town_code',
        'area_code',
    ];

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

    public function business_stats(): hasOneThrough
    {
        return $this->hasOneThrough(ExchangeStat::class, Business::class,'code','business_code','business_code','code');
    }

    public function getCompletionAttribute()
    {
        if($this->business == null){
            return null;
        }
        if($this->business->exchange_stats == null){
            return null;
        }
        return $this->business->exchange_stats->getCompletionRatePercentage();
    }

    public function getFeedbackAttribute()
    {
        if($this->business == null){
            return null;
        }
        if($this->business->exchange_stats == null){
            return null;
        }
        return $this->business->exchange_stats->getFeedbackRatePercentage();
    }

    public function getTradesAttribute()
    {
        if($this->business == null){
            return null;
        }
        if($this->business->exchange_stats == null){
            return null;
        }
        return $this->business->exchange_stats->no_of_trades_completed;
    }
}
