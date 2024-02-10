<?php

namespace App\Utils\Enums;

enum TaskTypeEnum: string
{
    case DATA = 'data';
    case SALES = 'sales';
    case VERIFICATION = 'verification';

    public static function toArray()
    {
        $values = [];

        foreach (self::cases() as $props) {
            array_push($values, $props->value);
        }

        return $values;
    }

}
