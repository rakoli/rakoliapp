<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory;

    public function areas(): HasMany
    {
        return $this->hasMany(Area::class, 'country_code', 'code');
    }

    public function businesses(): HasMany
    {
        return $this->hasMany(Business::class, 'country_code', 'code');
    }

    public function exchange_ads(): HasMany
    {
        return $this->hasMany(ExchangeAds::class, 'country_code', 'code');
    }

    public function financial_service_providers(): HasMany
    {
        return $this->hasMany(FinancialServiceProvider::class, 'country_code', 'code');
    }

    public function packages(): HasMany
    {
        return $this->hasMany(Package::class, 'country_code', 'code');
    }

    public function regions(): HasMany
    {
        return $this->hasMany(Region::class, 'country_code', 'code');
    }

    public function system_incomes(): HasMany
    {
        return $this->hasMany(SystemIncome::class, 'country_code', 'code');
    }

    public function towns(): HasMany
    {
        return $this->hasMany(Towns::class, 'country_code', 'code');
    }

    public function vas_contracts(): HasMany
    {
        return $this->hasMany(VasContract::class, 'country_code', 'code');
    }

    public function vas_feedbacks(): HasMany
    {
        return $this->hasMany(VasFeedback::class, 'country_code', 'code');
    }

    public function vas_tasks(): HasMany
    {
        return $this->hasMany(VasTask::class, 'country_code', 'code');
    }
}
