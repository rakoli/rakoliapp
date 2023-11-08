<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Towns extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'country_code',
        'region_code',
        'name',
        'code',
        'description'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_code', 'code');
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_code', 'code');
    }

    public function areas()
    {
        return $this->hasMany(Area::class, 'town_code', 'code');
    }

    public function exchange_ads()
    {
        return $this->hasMany(ExchangeAds::class, 'town_code', 'code');
    }

    public function locations()
    {
        return $this->hasMany(Location::class, 'town_code', 'code');
    }

    public function vas_tasks()
    {
        return $this->hasMany(VasTask::class, 'town_code', 'code');
    }

}
