<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VasFeedback extends Model
{
    use HasFactory;

    public function agent_business()
    {
        return $this->belongsTo(Business::class, 'agent_business_code', 'code');
    }

    public function vas_business()
    {
        return $this->belongsTo(Business::class, 'vas_provider_code', 'code');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_code', 'code');
    }

    public function vas_contract()
    {
        return $this->belongsTo(VasContract::class, 'vas_contract_code', 'code');
    }

    public function vas_task()
    {
        return $this->belongsTo(VasTask::class, 'vas_task_code', 'code');
    }
}
