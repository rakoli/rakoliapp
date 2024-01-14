<?php

namespace App\Utils\Enums;

enum TransactionCategoryEnum: string
{
    case INCOME = 'income';
    case EXPENSE = 'expense';
    case GENERAL = 'general';

    public function color()
    {
        return match ($this) {
            self::INCOME => 'badge badge-success',
            self::EXPENSE => 'badge badge-primary',
            self::GENERAL => 'badge badge-secondary',
        };
    }

    public function label()
    {
        return match ($this) {
            self::INCOME => 'Income',
            self::EXPENSE => 'Expenses',
            self::GENERAL => 'General',
        };
    }
}
