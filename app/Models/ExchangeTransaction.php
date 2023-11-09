<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeTransaction extends Model
{
    use HasFactory;

    public function exchange_ad()
    {
        return $this->belongsTo(ExchangeAds::class, 'exchange_ads_code', 'code');
    }

    public function financial_service_provider()
    {
        return $this->belongsTo(FinancialServiceProvider::class, 'fsp_code', 'code');
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'trader_business_code', 'code');
    }
}
