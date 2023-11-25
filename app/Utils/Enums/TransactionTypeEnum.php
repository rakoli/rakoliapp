<?php

namespace App\Utils\Enums;

enum TransactionTypeEnum : string
{
    case MONEY_IN = "IN";
    case MONEY_OUT = "OUT";

    public function color()
    {
        return match ($this){
            static::MONEY_OUT => "badge badge-danger",
            static::MONEY_IN => "badge badge-primary",
        };
    }
    public function label()
    {
        return match ($this){
            static::MONEY_OUT => "Money Out",
            static::MONEY_IN => "Money In",
        };
    }
}
