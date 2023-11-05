<?php

namespace App\Models;

use App\Models\Scopes\BusinessScoped;
use App\Models\Scopes\LocationScoped;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    use HasFactory;


    protected static function booted()
    {
        static::addGlobalScope(new LocationScoped());
        static::addGlobalScope(new BusinessScoped());
    }

    public function business()
    {
        return $this->belongsTo(Business::class,'business_code','code');
    }
    public function location()
    {
        return $this->belongsTo(Location::class,'location_code','code');
    }
    public function agency()
    {
        return $this->belongsTo(FinancialServiceProvider::class,'fsp_code','code');
    }
}
