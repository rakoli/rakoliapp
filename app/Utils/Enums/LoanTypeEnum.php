<?php

namespace App\Utils\Enums;

enum LoanTypeEnum : string
{

    case MONEY_IN = "money_in";

    case MONEY_OUT = "money_out";




    public function label() : string
    {
        return match ($this){

            static::MONEY_IN => "Money In",
            static::MONEY_OUT => "Money Out",

        };
    }
    public function color() : string
    {
        return match ($this){
            static::MONEY_OUT => "badge badge-warning",
            static::MONEY_IN => "badge badge-primary",
        };
    }

}
