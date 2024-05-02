<?php

namespace App\Models;

use App\Models\Scopes\BusinessScoped;
use App\Models\Scopes\LocationScoped;
use App\Utils\Enums\TransactionCategoryEnum;
use App\Utils\Enums\TransactionTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShiftCashTransaction extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'type' => TransactionTypeEnum::class,
        'category' => TransactionCategoryEnum::class,
    ];

    protected static function booted()
    {
        static::addGlobalScope(new LocationScoped());
        static::addGlobalScope(new BusinessScoped());
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class, 'business_code', 'code');
    }

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_code', 'code');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_code', 'code');
    }
    public function network(): BelongsTo
    {
        return $this->belongsTo(Network::class, 'network_code', 'code');
    }
}
