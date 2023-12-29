<?php

namespace App\Models;

use App\Models\Scopes\BusinessScoped;
use App\Models\Scopes\LocationScoped;
use Database\Factories\FinancialServiceProviderFactory;
use Database\Factories\SystemIncomeFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
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

    public function networks() : HasMany
    {
        return $this->hasMany(Network::class, 'fsp_code', 'code');
    }
}
