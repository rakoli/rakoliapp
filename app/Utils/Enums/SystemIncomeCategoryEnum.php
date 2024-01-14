<?php

namespace App\Utils\Enums;

enum SystemIncomeCategoryEnum: string
{
    case SUBSCRIPTION = 'subscription';
    case ADS = 'advertisement';
    case VAS = 'vas_fees';
}
