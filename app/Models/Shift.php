<?php

namespace App\Models;

use App\Models\Scopes\BusinessScoped;
use App\Models\Scopes\LocationScoped;
use App\Utils\Enums\ShiftStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shift extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'status' => ShiftStatusEnum::class,
    ];

    protected static function booted()
    {
        static::addGlobalScope(new LocationScoped());
        static::addGlobalScope(new BusinessScoped());
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_code', 'code');
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class, 'business_code', 'code');
    }

    public function shiftNetworks(): HasMany
    {
        return $this->hasMany(ShiftNetwork::class, 'shift_id', 'id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(ShiftTransaction::class, 'shift_id','id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_code', 'code');
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    public function networks(): BelongsToMany
    {
        return $this->belongsToMany(Network::class, 'shift_networks', 'shift_id', 'network_code')
            ->withPivot('id', 'business_code', 'location_code', 'balance_old', 'balance_new')
            ->withTimestamps();
    }

    public function shift_transactions(): HasMany
    {
        return $this->hasMany(ShiftTransaction::class);
    }

    public function shorts(): HasMany
    {
        return $this->hasMany(Short::class);
    }
}
