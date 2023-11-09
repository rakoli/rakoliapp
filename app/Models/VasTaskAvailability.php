<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VasTaskAvailability extends Model
{
    use HasFactory;

    public function business()
    {
        return $this->belongsTo(Business::class, 'agent_code', 'code');
    }

    public function vas_task()
    {
        return $this->belongsTo(VasTask::class, 'vas_task_code', 'code');
    }

}
