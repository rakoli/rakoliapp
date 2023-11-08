<?php

namespace App\Models;

use App\Models\Scopes\BusinessScoped;
use App\Models\Scopes\LocationScoped;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FinancialServiceProvider extends Model
{
    use HasFactory;

    public function country() : BelongsTo
    {
        return $this->belongsTo(related: Country::class , foreignKey: 'country_code', ownerKey: 'code');
    }

    public function exchange_transactions()
    {
        return $this->hasMany(ExchangeTransaction::class, 'fsp_code', 'code');
    }

    public function networks()
    {
        return $this->hasMany(Network::class, 'fsp_code', 'code');
    }
}
