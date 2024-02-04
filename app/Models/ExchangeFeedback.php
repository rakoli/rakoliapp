<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExchangeFeedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'exchange_trnx_id' ,
        'reviewed_business_code',
        'review',
        'review_comment',
        'reviewer_user_code'
    ];

    public function reviewer() : BelongsTo
    {
        return $this->belongsTo(User::class,'reviewer_user_code','code');
    }

    public function reviewed_business() : BelongsTo
    {
        return $this->belongsTo(Business::class,'reviewed_business_code','code');
    }
}
