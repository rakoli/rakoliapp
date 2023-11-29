<?php

namespace App\Utils\Enums;

enum LoanPaymentStatusEnum : string
{

    case UN_PAID = "un_paid";
    case PARTIALLY = "partially";
    case FULL_PAID = "fully_paid";


    public function label() : string
    {
        return match ($this){

            static::FULL_PAID => "Fully Paid",
            static::PARTIALLY => "Partially Paid",
            static::UN_PAID => "Un paid",
        };
    }
    public function color() : string
    {
        return match ($this){
            static::FULL_PAID => "badge badge-success",
            static::PARTIALLY => "badge badge-warning",
            static::UN_PAID => "badge badge-danger",
        };
    }


}
