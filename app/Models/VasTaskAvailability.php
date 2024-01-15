<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VasTaskAvailability extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function business() : BelongsTo
    {
        return $this->belongsTo(Business::class, 'agent_code', 'code');
    }

    public function vas_task() : BelongsTo
    {
        return $this->belongsTo(VasTask::class, 'vas_task_code', 'code');
    }

}
