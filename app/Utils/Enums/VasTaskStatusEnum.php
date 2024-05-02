<?php

namespace App\Utils\Enums;

enum VasTaskStatusEnum: string
{
    case ACTIVE = 'active';
    case PENDING = 'pending';
    case DISABLED = 'disabled';
    case DELETED = 'deleted';

    public static function userCantSeeArray()
    {
        return ['pending', 'deleted'];
    }

    public static function userViewable()
    {
        $values = [];

        foreach (self::cases() as $props) {
            if (in_array($props->value, self::userCantSeeArray())) {
                continue;
            }
            array_push($values, $props->value);
        }

        return $values;
    }

    public static function toArray()
    {
        $values = [];

        foreach (self::cases() as $props) {
            array_push($values, $props->value);
        }

        return $values;
    }
}
