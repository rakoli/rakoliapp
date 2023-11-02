<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VasPayment extends Model
{
    use HasFactory;

    public function contract() : BelongsTo
    {
        return $this->belongsTo(VasContract::class,'vas_contract_code','code');
    }

    public function payee() : BelongsTo
    {
        return $this->belongsTo(Business::class,'payee_business_code','code');
    }

}
