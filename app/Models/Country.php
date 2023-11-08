<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    public function areas()
    {
        return $this->hasMany(Area::class, 'country_code', 'code');
    }

    public function businesses()
    {
        return $this->hasMany(Business::class, 'country_code', 'code');
    }

    public function exchange_ads()
    {
        return $this->hasMany(ExchangeAds::class, 'country_code', 'code');
    }

    public function financial_service_providers()
    {
        return $this->hasMany(FinancialServiceProvider::class, 'country_code', 'code');
    }

    public function packages()
    {
        return $this->hasMany(Package::class, 'country_code', 'code');
    }

    public function regions()
    {
        return $this->hasMany(Region::class, 'country_code', 'code');
    }

    public function system_incomes()
    {
        return $this->hasMany(SystemIncome::class, 'country_code', 'code');
    }

    public function towns()
    {
        return $this->hasMany(Towns::class, 'country_code', 'code');
    }

    public function vas_contracts()
    {
        return $this->hasMany(VasContract::class, 'country_code', 'code');
    }

    public function vas_feedbacks()
    {
        return $this->hasMany(VasFeedback::class, 'country_code', 'code');
    }

    public function vas_tasks()
    {
        return $this->hasMany(VasTask::class, 'country_code', 'code');
    }

}
