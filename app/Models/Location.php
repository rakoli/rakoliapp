<?php

namespace App\Models;

use App\Models\Scopes\BusinessScoped;
use App\Models\Scopes\LocationScoped;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::addGlobalScope(new BusinessScoped);
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class, 'Business_Code', 'Business_Code');
    }

    public function networks(): HasMany
    {
        return $this->hasMany(Network::class, 'location_code', 'code');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'location_users',
            'location_code',
            'user_code',
            'code',
            'code'
        );
    }
}
