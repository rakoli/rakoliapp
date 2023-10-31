<?php

namespace App\Models;

use Database\Factories\SystemIncomeFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemIncome extends Model
{
    use HasFactory;

    protected static function newFactory(): Factory
    {
        return SystemIncomeFactory::new();
    }

}
