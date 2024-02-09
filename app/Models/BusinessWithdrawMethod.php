<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessWithdrawMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_code',
        'requesting_user_code',
        'amount_currency',
        'method_name',
        'method_ac_name',
        'method_ac_number',
        'status',
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class, 'business_code', 'code');
    }
}
