<?php

namespace App\Models;

use Database\Factories\SystemIncomeFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SystemIncome extends Model
{
    use HasFactory;

    protected static function newFactory(): Factory
    {
        return SystemIncomeFactory::new();
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_code', 'code');
    }

}
