<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VasContract extends Model
{
    use HasFactory;

    public function business() : BelongsTo
    {
        return $this->belongsTo(Business::class, 'vas_business_code', 'code');
    }

    public function agent() : BelongsTo
    {
        return $this->belongsTo(Business::class, 'agent_business_code', 'code');
    }

    public function country() : BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_code', 'code');
    }

    public function vas_task() : BelongsTo
    {
        return $this->belongsTo(VasTask::class, 'vas_task_code', 'code');
    }

    public function vas_chats() : HasMany
    {
        return $this->hasMany(VasChat::class, 'vas_contract_code', 'code');
    }

    public function vas_contract_resources() : HasMany
    {
        return $this->hasMany(VasContractResource::class, 'vas_contract_code', 'code');
    }

    public function vas_feedbacks() : HasMany
    {
        return $this->hasMany(VasFeedback::class, 'vas_contract_code', 'code');
    }

    public function vas_payments() : HasMany
    {
        return $this->hasMany(VasPayment::class, 'vas_contract_code', 'code');
    }

    public function vas_submissions() : HasMany
    {
        return $this->hasMany(VasSubmission::class, 'vas_contract_code', 'code');
    }

    public function isUserAllowed(User $user)
    {
        $isRelated = false;

        if($this->business->code == $user->business_code){
            $isRelated = true;
        }
        if($this->agent->code == $user->business_code){
            $isRelated = true;
        }

        return $isRelated;
    }

}
