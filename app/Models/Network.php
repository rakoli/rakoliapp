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

    public function loans()
    {
        return $this->hasMany(Loan::class, 'network_code', 'code');
    }

    public function shifts()
    {
        return $this->belongsToMany(Shift::class, 'shift_networks', 'network_code')
            ->withPivot('id', 'business_code', 'location_code', 'balance_old', 'balance_new')
            ->withTimestamps();
    }

    public function shift_transactions()
    {
        return $this->hasMany(ShiftTransaction::class, 'network_code', 'code');
    }

    public function shorts()
    {
        return $this->hasMany(Short::class, 'network_code', 'code');
    }
}
