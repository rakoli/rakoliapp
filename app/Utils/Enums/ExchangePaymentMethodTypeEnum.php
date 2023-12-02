<?php

namespace App\Utils\Enums;

enum ExchangePaymentMethodTypeEnum : string
{
    case OWNER_RECEIVE = "sell"; //OWNER_SELL
    case OWNER_SEND = "buy";//OWNER_BUY
}
