<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
