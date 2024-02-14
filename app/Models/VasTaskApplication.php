<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VasTaskApplication extends Model
{
    use HasFactory;

    public function agent() : BelongsTo
    {
        return $this->belongsTo(Business::class, 'agent_business_code', 'code');
    }

    public function vas_task() : BelongsTo
    {
        return $this->belongsTo(VasTask::class, 'vas_task_code', 'code');
    }
}
