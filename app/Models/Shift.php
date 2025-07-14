<?php

namespace App\Models;

use App\Models\Scopes\BusinessScoped;
use App\Models\Scopes\LocationScoped;
use App\Models\Scopes\UserScoped;
use App\Utils\Enums\ShiftStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Shift extends Model
{
    use HasFactory;
    use Searchable;
    use LogsActivity;

    protected $guarded = ['id'];

    protected $casts = [
        'status' => ShiftStatusEnum::class,
    ];

    protected static function booted()
    {
        static::addGlobalScope(new LocationScoped());
        static::addGlobalScope(new BusinessScoped());
        // static::addGlobalScope(new UserScoped());
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
        return $this->hasMany(ShiftTransaction::class, 'shift_id', 'id');
    }

    public function cashTransactions(): HasMany
    {
        return $this->hasMany(ShiftCashTransaction::class, 'shift_id', 'id');
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

    public function scopeOpen(Builder $query)
    {
        $query->where('status', ShiftStatusEnum::OPEN);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logAll();
    }
}
