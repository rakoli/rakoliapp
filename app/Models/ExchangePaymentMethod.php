<?php

namespace App\Models;

use App\Utils\Enums\ExchangePaymentMethodTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExchangePaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'exchange_ads_code',
        'type',
        'method_name',
        'account_number',
        'account_name',
    ];

    public function exchange_ad() : BelongsTo
    {
        return $this->belongsTo(ExchangeAds::class,'exchange_ads_code','code');
    }

    public static function getAcceptedList($countryCode)
    {
        $fsps = FinancialServiceProvider::where('country_code',$countryCode)->get(['name','code'])->toArray();
        array_unshift($fsps,["name"=>"CASH",'code'=>'CASH']);
        return $fsps;
    }
}
