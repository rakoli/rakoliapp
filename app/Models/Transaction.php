<?php

namespace App\Models;

use App\Models\Scopes\BusinessScoped;
use App\Models\Scopes\LocationScoped;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;
    protected static function booted()
    {
        static::addGlobalScope(new LocationScoped());
        static::addGlobalScope(new BusinessScoped());
    }


    public function business() : BelongsTo
    {
        return  $this->belongsTo(Business::class,'business_code','code');
    }

    public function network() : BelongsTo
    {
        return  $this->belongsTo(Network::class,'network_code','code')->with('agency');
    }
    public function shift() : BelongsTo
    {
        return  $this->belongsTo(Shift::class);
    }
}
