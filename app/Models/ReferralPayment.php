<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReferralPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'referral_id',
        'amount',
        'payment_type',
        'payment_status',
        'payment_method',
        'payment_reference',
        'notes',
        'paid_at',
        'processed_by'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function referral(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referral_id');
    }

    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /**
     * Scopes
     */
    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('payment_type', $type);
    }

    public function scopeByDateRange($query, $start, $end)
    {
        return $query->whereBetween('created_at', [$start, $end]);
    }

    /**
     * Methods
     */
    public function markAsPaid($paymentMethod = null, $reference = null, $processedBy = null)
    {
        $this->update([
            'payment_status' => 'paid',
            'payment_method' => $paymentMethod,
            'payment_reference' => $reference,
            'paid_at' => now(),
            'processed_by' => $processedBy
        ]);
    }

    public function markAsPartial($paidAmount, $paymentMethod = null, $reference = null, $processedBy = null)
    {
        $this->update([
            'payment_status' => 'partial',
            'amount' => $paidAmount,
            'payment_method' => $paymentMethod,
            'payment_reference' => $reference,
            'paid_at' => now(),
            'processed_by' => $processedBy
        ]);
    }

    public function cancel($reason = null)
    {
        $this->update([
            'payment_status' => 'cancelled',
            'notes' => $reason
        ]);
    }

    /**
     * Static methods for creating payments
     */
    public static function createRegistrationBonus($salesUserId, $referralId, $amount = 500)
    {
        return static::create([
            'user_id' => $salesUserId,
            'referral_id' => $referralId,
            'amount' => $amount,
            'payment_type' => 'registration_bonus',
            'payment_status' => 'pending'
        ]);
    }

    public static function createTransactionBonus($salesUserId, $referralId, $week, $amount = 1000)
    {
        $type = $week === 1 ? 'transaction_bonus_week1' : 'transaction_bonus_week2';

        return static::create([
            'user_id' => $salesUserId,
            'referral_id' => $referralId,
            'amount' => $amount,
            'payment_type' => $type,
            'payment_status' => 'pending'
        ]);
    }
}
