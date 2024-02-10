<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VasContractResource extends Model
{
    use HasFactory;

    public function vas_contract(): BelongsTo
    {
        return $this->belongsTo(VasContract::class, 'vas_contract_code', 'code');
    }
}
