<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VasContract extends Model
{
    use HasFactory;

    public function business()
    {
        return $this->belongsTo(Business::class, 'vas_business_code', 'code');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_code', 'code');
    }

    public function vas_task()
    {
        return $this->belongsTo(VasTask::class, 'vas_task_code', 'code');
    }

    public function vas_chats()
    {
        return $this->hasMany(VasChat::class, 'vas_contract_code', 'code');
    }

    public function vas_contract_resources()
    {
        return $this->hasMany(VasContractResource::class, 'vas_contract_code', 'code');
    }

    public function vas_feedbacks()
    {
        return $this->hasMany(VasFeedback::class, 'vas_contract_code', 'code');
    }

    public function vas_payments()
    {
        return $this->hasMany(VasPayment::class, 'vas_contract_code', 'code');
    }

    public function vas_submissions()
    {
        return $this->hasMany(VasSubmission::class, 'vas_contract_code', 'code');
    }

}
