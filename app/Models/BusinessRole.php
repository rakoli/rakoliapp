<?php

namespace App\Models;

use App\Utils\Traits\BusinessAuthorization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessRole extends Model
{
    use BusinessAuthorization, HasFactory, SoftDeletes;

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
