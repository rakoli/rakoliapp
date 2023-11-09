<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdsExchangeChat extends Model
{
    use HasFactory;

    public function exchange_ad() : BelongsTo
    {
        return $this->belongsTo(ExchangeAds::class, 'exchange_ads_code', 'code');
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_code', 'code');
    }

}
