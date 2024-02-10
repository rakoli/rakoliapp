<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VasSubmission extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function submitter() : BelongsTo
    {
        return $this->belongsTo(User::class, 'submitter_user_code', 'code');
    }

    public function reviewer() : BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_user_code', 'code');
    }

    public function vas_contract(): BelongsTo
    {
        return $this->belongsTo(VasContract::class, 'vas_contract_code', 'code');
    }

}
