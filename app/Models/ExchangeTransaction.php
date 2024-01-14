<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExchangeTransaction extends Model
{
    use HasFactory;

    public function exchange_ad(): BelongsTo
    {
        return $this->belongsTo(ExchangeAds::class, 'exchange_ads_code', 'code');
    }

    public function financial_service_provider(): BelongsTo
    {
        return $this->belongsTo(FinancialServiceProvider::class, 'fsp_code', 'code');
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class, 'trader_business_code', 'code');
    }
}
