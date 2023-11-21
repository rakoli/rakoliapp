<?php

namespace App\Utils\Enums;

enum BusinessUploadDocumentTypeEnums : string
{

    case TAX_ID = "tax_id";
    case REGISTRATION = "registration_certificate";

    case NAT= "identification_document";


    public function label()
    {
        return match ($this){
            static::TAX_ID => "Tax Certificate ID",
            static::REGISTRATION => "Business Registration Certificate",
            static::NAT => "Identification Document",
        };

    }

}
