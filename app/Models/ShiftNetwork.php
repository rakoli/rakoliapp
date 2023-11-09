<?php

namespace App\Models;

use App\Models\Scopes\BusinessScoped;
use App\Models\Scopes\LocationScoped;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShiftNetwork extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::addGlobalScope(new LocationScoped());
        static::addGlobalScope(new BusinessScoped());
    }


    public function network(): BelongsTo
    {
        return $this->belongsTo(Network::class,'network_code','code')->with('agency');
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_code', 'code');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_code', 'code');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

}
