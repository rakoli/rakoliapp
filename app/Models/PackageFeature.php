<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageFeature extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class, 'package_code', 'code');
    }

    public function feature(): BelongsTo
    {
        return $this->belongsTo(PackageAvailableFeatures::class, 'feature_code', 'code');
    }
}
