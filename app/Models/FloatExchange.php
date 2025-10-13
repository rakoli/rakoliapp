<?php

namespace App\Models;

use App\Models\Scopes\BusinessScoped;
use App\Models\Scopes\LocationScoped;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FloatExchange extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'user_code',
        'business_code',
        'location_code',
        'shift_id',
        'from_network_code',
        'from_fsp_code',
        'to_network_code',
        'to_fsp_code',
        'amount',
        'fee',
        'total_amount',
        'currency',
        'from_balance_before',
        'from_balance_after',
        'to_balance_before',
        'to_balance_after',
        'status',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'fee' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'from_balance_before' => 'decimal:2',
        'from_balance_after' => 'decimal:2',
        'to_balance_before' => 'decimal:2',
        'to_balance_after' => 'decimal:2',
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

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_code', 'code');
    }

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class, 'shift_id', 'id');
    }

    public function fromNetwork(): BelongsTo
    {
        return $this->belongsTo(Network::class, 'from_network_code', 'code');
    }

    public function toNetwork(): BelongsTo
    {
        return $this->belongsTo(Network::class, 'to_network_code', 'code');
    }

    public function fromFsp(): BelongsTo
    {
        return $this->belongsTo(FinancialServiceProvider::class, 'from_fsp_code', 'code');
    }

    public function toFsp(): BelongsTo
    {
        return $this->belongsTo(FinancialServiceProvider::class, 'to_fsp_code', 'code');
    }
}
