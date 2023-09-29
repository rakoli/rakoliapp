<?php

namespace App\Models;

use App\Models\Scopes\BusinessScoped;
use App\Models\Scopes\LocationScoped;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinancialServiceProvider extends Model
{
    use HasFactory;



    public function country() : BelongsTo
    {
        return $this->belongsTo(related: Country::class , foreignKey: 'country_code', ownerKey: 'code');
    }
}
