<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VasChat extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_code', 'code');
    }

    public function vas_contract() : BelongsTo
    {
        return $this->belongsTo(VasContract::class, 'vas_contract_code', 'code');
    }
}
