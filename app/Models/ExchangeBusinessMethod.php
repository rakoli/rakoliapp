<?php

namespace App\Models;

use App\Utils\Traits\BusinessAuthorization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExchangeBusinessMethod extends Model
{
    use BusinessAuthorization, HasFactory;

    protected $fillable = [
        'business_code',
        'nickname',
        'method_name',
        'account_number',
        'account_name',
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class, 'business_code', 'code');
    }
}
