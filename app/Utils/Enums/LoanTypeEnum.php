<?php

namespace App\Utils\Enums;

enum LoanTypeEnum: string
{
    case MONEY_IN = 'IN';
    case MONEY_OUT = 'OUT';

    public function label(): string
    {
        return match ($this) {
            self::MONEY_IN => 'Received',
            self::MONEY_OUT => 'Given',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::MONEY_OUT => 'badge badge-danger',
            self::MONEY_IN => 'badge badge-primary',
        };
    }
}
