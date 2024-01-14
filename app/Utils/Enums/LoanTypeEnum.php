<?php

namespace App\Utils\Enums;

enum LoanTypeEnum: string
{
    case MONEY_IN = 'money_in';

    case MONEY_OUT = 'money_out';

    public function label(): string
    {
        return match ($this) {
            self::MONEY_OUT => 'Withdraw',
            self::MONEY_IN => 'Deposit',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::MONEY_OUT => 'badge badge-warning',
            self::MONEY_IN => 'badge badge-primary',
        };
    }
}
