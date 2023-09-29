<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    use HasFactory;

    public function country() : BelongsTo
    {
        return  $this->belongsTo(Country::class,'country_code','code');
    }
    public function features() : HasMany
    {
        return  $this->hasMany(PackageFeature::class,'package_code','code');
    }
}
