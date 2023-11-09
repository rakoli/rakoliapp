<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortPayment extends Model
{
    use HasFactory;

    public function shorts()
    {
        return $this->belongsTo(Short::class, 'short_code', 'code');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_code', 'code');
    }
}
