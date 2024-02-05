<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VasFeedback extends Model
{
    use HasFactory;

    public function agent_business(): BelongsTo
    {
        return $this->belongsTo(Business::class, 'agent_business_code', 'code');
    }

    public function vas_business(): BelongsTo
    {
        return $this->belongsTo(Business::class, 'vas_provider_code', 'code');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_code', 'code');
    }

    public function vas_contract(): BelongsTo
    {
        return $this->belongsTo(VasContract::class, 'vas_contract_code', 'code');
    }

    public function vas_task(): BelongsTo
    {
        return $this->belongsTo(VasTask::class, 'vas_task_code', 'code');
    }
}
