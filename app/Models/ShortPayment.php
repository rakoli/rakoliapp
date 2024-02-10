<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShortPayment extends Model
{
    use HasFactory;

    public function shorts(): BelongsTo
    {
        return $this->belongsTo(Short::class, 'short_code', 'code');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_code', 'code');
    }
}
