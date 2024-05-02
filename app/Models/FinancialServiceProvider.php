<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FinancialServiceProvider extends Model
{
    use HasFactory;

    public static $tzDefaultsFSPs = ['M-PESA','TIGOPESA','AIRTELMONEY','HALOPESA','T-PESA','CRDB BANK','NMB BANK'];
    public static $keDefaultsFSPs = ['M-PESA','AIRTELMONEY','YUCASH','ORANGE MONEY','KCB Bank','Equity Bank Kenya','Cooperative Bank of Kenya'];

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
}
