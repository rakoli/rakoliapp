<?php

namespace App\Utils\Enums;

enum TransactionTypeEnum : string
{
    case MONEY_IN = "IN";
    case MONEY_OUT = "OUT";

    public function color()
    {
        return match ($this){
            static::MONEY_OUT => "badge badge-warning",
            static::MONEY_IN => "badge badge-primary",
        };
    }
    public function label()
    {
        return match ($this){
            static::MONEY_OUT => "Money In",
            static::MONEY_IN => "Money Out",
        };
    }
}
