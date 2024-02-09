<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessAccountTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_code',
        'type',
        'category',
        'amount',
        'amount_currency',
        'balance_old',
        'balance_new',
        'description',
        'note',
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class, 'business_code', 'code');
    }
}
