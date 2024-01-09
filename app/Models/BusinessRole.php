<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessRole extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_code',
        'code',
        'name',
        'description',
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class, 'Business_Code', 'Business_Code');
    }
}
