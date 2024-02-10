<?php

namespace App\Utils\Enums;

enum IDCardType: string
{
    case NAT_ID = 'national_id_card';
    case DRIVER_LICENCE = 'driving_licence';

    case PASSPORT = 'passport';

    public function label()
    {
        return match ($this) {

            self::NAT_ID => 'National ID No',
            self::DRIVER_LICENCE => 'Driving licence',
            self::PASSPORT => 'Passport',
        };

    }
}
