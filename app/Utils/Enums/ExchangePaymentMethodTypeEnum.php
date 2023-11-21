<?php

namespace App\Utils\Enums;

enum ExchangePaymentMethodTypeEnum : string
{
    case OWNER_RECEIVE = "sell";
    case OWNER_SEND = "buy";
}
