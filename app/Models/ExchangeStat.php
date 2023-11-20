<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExchangeStat extends Model
{
    use HasFactory;

    public function business() : BelongsTo
    {
        return $this->belongsTo(Business::class,'business_code','code');
    }
}
