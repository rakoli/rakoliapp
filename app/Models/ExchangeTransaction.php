<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ExchangeTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'exchange_ads_code',
        'owner_business_code',
        'trader_business_code',
        'trader_action_type',
        'trader_action_method_id',
        'trader_action_method',
        'for_method',
        'amount',
        'amount_currency',
        'status',
        'trader_comments',
    ];

    public function owner_business() : BelongsTo
    {
        return $this->belongsTo(Business::class,'owner_business_code','code');
    }

    public function trader_business() : BelongsTo
    {
        return $this->belongsTo(Business::class,'trader_business_code','code');
    }

    public function exchange_ad() : BelongsTo
    {
        return $this->belongsTo(ExchangeAds::class, 'exchange_ads_code', 'code');
    }

    public function business() : BelongsTo
    {
        return $this->belongsTo(Business::class, 'trader_business_code', 'code');
    }

    public function paymentMethod() : HasOne
    {
        return $this->HasOne(ExchangePaymentMethod::class,'id','trader_action_method_id');
    }

    public function exchange_chats() : HasMany
    {
        return $this->hasMany(ExchangeChat::class,'exchange_trnx_id','id');
    }

    public function isUserAllowed(User $user)
    {
        $isRelated = false;

        if($this->owner_business->code == $user->business_code){
            $isRelated = true;
        }
        if($this->trader_business->code == $user->business_code){
            $isRelated = true;
        }

        return $isRelated;
    }
}
