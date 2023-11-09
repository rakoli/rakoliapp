<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VasChat extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'sender_code', 'code');
    }

    public function vas_contract()
    {
        return $this->belongsTo(VasContract::class, 'vas_contract_code', 'code');
    }
}
