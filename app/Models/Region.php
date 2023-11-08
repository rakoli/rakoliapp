<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'country_code',
        'name',
        'code',
        'description'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_code', 'code');
    }

    public function areas()
    {
        return $this->hasMany(Area::class, 'region_code', 'code');
    }

    public function towns()
    {
        return $this->hasMany(Towns::class, 'region_code', 'code');
    }

    public function exchange_ads()
    {
        return $this->hasMany(ExchangeAds::class, 'region_code', 'code');
    }

    public function locations()
    {
        return $this->hasMany(Location::class, 'region_code', 'code');
    }

    public function vas_tasks()
    {
        return $this->hasMany(VasTask::class, 'region_code', 'code');
    }

}
