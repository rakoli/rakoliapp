<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Short extends Model
{
    use HasFactory;

    public function business() : BelongsTo
    {
        return $this->belongsTo(Business::class, 'business_code', 'code');
    }

    public function location() : BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_code', 'code');
    }

    public function network() : BelongsTo
    {
        return $this->belongsTo(Network::class, 'network_code', 'code');
    }

    public function shift() : BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_code', 'code');
    }

    public function short_payments() : HasMany
    {
        return $this->hasMany(ShortPayment::class, 'short_code', 'code');
    }

}
