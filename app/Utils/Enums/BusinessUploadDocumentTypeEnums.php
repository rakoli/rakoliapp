<?php

namespace App\Utils\Enums;

enum BusinessUploadDocumentTypes : string
{

    case TAX_ID = "Tax id";
    case REGISTRATION = "Registration";

    case NAT= "Identification Document";


    public function label()
    {
        return match ($this){

            static::TAX_ID => "Tax Certificate ID",
            static::REGISTRATION => "Business Registration",
            static::NAT => "Identification Document",
        };

    }

}
