<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExchangeChat extends Model
{
    use HasFactory;

    protected $fillable = [
        'exchange_trnx_id',
        'sender_code',
        'message',
    ];

    public function exchange_transaction(): BelongsTo
    {
        return $this->belongsTo(ExchangeTransaction::class, 'exchange_trnx_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_code', 'code');
    }
}
