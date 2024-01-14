<?php

namespace App\Utils\Enums;

enum TransactionTypeEnum: string
{
    case MONEY_IN = 'IN';
    case MONEY_OUT = 'OUT';

    public function color()
    {
        return match ($this) {
            self::MONEY_OUT => 'badge badge-danger',
            self::MONEY_IN => 'badge badge-primary',
        };
    }

    public function label()
    {
        return match ($this) {
            self::MONEY_OUT => 'Money Out',
            self::MONEY_IN => 'Money In',
        };
    }
}
