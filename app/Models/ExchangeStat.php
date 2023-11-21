<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExchangeStat extends Model
{
    use HasFactory;

    public function business() : BelongsTo
    {
        return $this->belongsTo(Business::class,'business_code','code');
    }

    public function getCompletionRatePercentage()
    {
        return number_format(($this->no_of_trades_completed/($this->no_of_trades_cancelled+$this->no_of_trades_completed))*100,0);
    }

    public function getFeedbackRatePercentage()
    {
        return number_format(($this->no_of_positive_feedback/($this->no_of_positive_feedback+$this->no_of_negative_feedback))*100,0);
    }
}
