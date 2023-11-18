<?php

namespace App\Utils\Enums;

enum IDCardType : string
{

    case NAT_ID = "National_ID_Card";
    case DRIVER_LICENCE = "Driving_Licence";

    case PASSPORT= "PASSPORT";


    public function label()
    {
        return match ($this){

            static::NAT_ID => "National ID No",
            static::DRIVER_LICENCE => "Driving licence",
            static::PASSPORT => "Passport",
        };

    }

}
