<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferrerPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_code',
        'amount',
        'payment_type',
        'period',
        'status',
        'notes',
        'paid_at'
    ];

    protected $casts = [
        'paid_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_code', 'code');
    }
}
