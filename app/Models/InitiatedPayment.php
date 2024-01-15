<?php

namespace App\Models;

use App\Utils\Enums\InitiatedPaymentStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InitiatedPayment extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => InitiatedPaymentStatusEnum::class,
    ];

    protected $fillable = [
        'country_code',
        'business_code',
        'code',
        'channel',
        'income_category',
        'description',
        'amount',
        'amount_currency',
        'expiry_time',
        'pay_url',
        'pay_code',
        'channel_ref_name',
        'channel_ref',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_code', 'code');
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class, 'business_code', 'code');
    }
}
