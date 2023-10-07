<?php

namespace App\Utils\Enums;

enum WalkThroughStepEnums : string
{

    case BUSINESS = "business";

    case LOCATION = "location";

    case NETWORK = "network";

    case COMPLETED = "completed";


    public function description()
    {
        return match ($this){

            static::BUSINESS => "Add business details",
            static::LOCATION => "Add business locations",
            static::NETWORK => "Add location tills",
            static::COMPLETED => "You have completed Registration",
        };
    }
    public function completed()
    {
        if (static::BUSINESS)
        {
            return match ($this){

                static::BUSINESS =>false,
                static::LOCATION => false,
                static::NETWORK => false,
                static::COMPLETED => false,
            };
        }
        if (static::LOCATION)
        {
            return match ($this){

                static::BUSINESS =>true,
                static::LOCATION => false,
                static::NETWORK => false,
                static::COMPLETED => false,
            };
        }
        if (static::NETWORK)
        {
            return match ($this){

                static::BUSINESS =>true,
                static::LOCATION => true,
                static::NETWORK => false,
                static::COMPLETED => false,
            };
        }
        if (static::COMPLETED)
        {
            return match ($this){

                static::BUSINESS =>true,
                static::LOCATION => true,
                static::NETWORK => true,
                static::COMPLETED => true,
            };
        }
    }

}
