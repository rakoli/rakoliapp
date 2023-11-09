<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VasContractResource extends Model
{
    use HasFactory;

    public function vas_contract()
    {
        return $this->belongsTo(VasContract::class, 'vas_contract_code', 'code');
    }
}
