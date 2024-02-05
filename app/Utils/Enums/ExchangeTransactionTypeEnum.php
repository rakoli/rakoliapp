<?php

namespace App\Utils\Enums;

enum ExchangeTransactionTypeEnum: string
{
    case BUY = 'buy';
    case SELL = 'sell';

    public static function toArray()
    {
        $values = [];

        foreach (self::cases() as $props) {
            array_push($values, $props->value);
        }

        return $values;
    }
}
