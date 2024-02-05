<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExchangeStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_code',
        'no_of_trades_completed',
        'no_of_trades_cancelled',
        'no_of_positive_feedback',
        'no_of_negative_feedback',
        'volume_traded',
        'completion',
        'feedback',
    ];

    protected static function booted(): void
    {
        parent::boot();

        static::created(function (ExchangeStat $stat) {
            if ($stat->no_of_trades_completed > 0) {
                $stat->completion = $stat->calculateCompletionRate($stat->no_of_trades_completed, $stat->no_of_trades_cancelled);
            }
            $stat->feedback = $stat->calculateFeedbackWeightedAverage($stat->no_of_positive_feedback, $stat->no_of_negative_feedback);
            $stat->save();
        });

        static::updating(function (ExchangeStat $stat) {
            if ($stat->isDirty('no_of_trades_completed') || $stat->isDirty('no_of_trades_cancelled')) {
                $stat->completion = $stat->calculateCompletionRate($stat->no_of_trades_completed, $stat->no_of_trades_cancelled);
            }
            if ($stat->isDirty('no_of_positive_feedback') || $stat->isDirty('no_of_negative_feedback')) {
                $stat->feedback = $stat->calculateFeedbackWeightedAverage($stat->no_of_positive_feedback, $stat->no_of_negative_feedback);
            }
        });
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class, 'business_code', 'code');
    }

    public function calculateCompletionRate($no_completed, $no_cancelled)
    {
        return $no_completed / ($no_cancelled + $no_completed);
    }

    public function getCompletionRatePercentage()
    {
        return number_format($this->completion * 100, 0);
    }

    public function calculateFeedbackWeightedAverage($positiveFeedbacks, $negativeFeedbacks)
    {
        if (($positiveFeedbacks + $negativeFeedbacks) == 0) {
            return 0;
        }
        $weightedAverage = $positiveFeedbacks / ($positiveFeedbacks + $negativeFeedbacks);

        return $weightedAverage;
    }

    public function getFeedbackRatePercentage()
    {
        return number_format($this->feedback * 100, 0);
    }
}
