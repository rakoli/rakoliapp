<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FinancialServiceProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_code',
        'code',
        'name',
        'desc',
        'pic',
        'is_default',
        'withdraw_commission_rate',
        'deposit_commission_rate',
    ];

    public static $tzDefaultsFSPs = ['M-PESA','MIXXBYYAS','AIRTELMONEY'];
    public static $keDefaultsFSPs = ['M-PESA','AIRTELMONEY','ORANGE MONEY'];

    public function country(): BelongsTo
    {
        return $this->belongsTo(related: Country::class, foreignKey: 'country_code', ownerKey: 'code');
    }

    public function exchange_transactions(): HasMany
    {
        return $this->hasMany(ExchangeTransaction::class, 'fsp_code', 'code');
    }

    public function networks(): HasMany
    {
        return $this->hasMany(Network::class, 'fsp_code', 'code');
    }

    public function getLogo(){
        if (file_exists( public_path() . '/assets/media/fsp_logos/'.$this->logo)) {
            return asset('/assets/media/fsp_logos/'.$this->logo);
        } else {
            return asset('/assets/media/fsp_logos/default.jpg');
        }
    }

    /**
     * Calculate withdraw commission for a given amount
     */
    public function calculateWithdrawCommission($amount)
    {
        return $amount * $this->withdraw_commission_rate;
    }

    /**
     * Calculate deposit commission for a given amount
     */
    public function calculateDepositCommission($amount)
    {
        return $amount * $this->deposit_commission_rate;
    }

    /**
     * Get withdraw commission rate as percentage
     */
    public function getWithdrawCommissionPercentage()
    {
        return $this->withdraw_commission_rate * 100;
    }

    /**
     * Get deposit commission rate as percentage
     */
    public function getDepositCommissionPercentage()
    {
        return $this->deposit_commission_rate * 100;
    }
}
