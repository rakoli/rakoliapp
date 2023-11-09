<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanPayment extends Model
{
    use HasFactory;

    public function loan()
    {
        return $this->belongsTo(Loan::class, 'loan_code', 'code');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_code', 'code');
    }

}
