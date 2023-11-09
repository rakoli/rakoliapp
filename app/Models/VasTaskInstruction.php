<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VasTaskInstruction extends Model
{
    use HasFactory;

    public function vas_task()
    {
        return $this->belongsTo(VasTask::class, 'vas_task_code', 'code');
    }

}
