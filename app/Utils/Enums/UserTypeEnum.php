<?php

namespace App\Utils\Enums;

enum UserTypeEnum: string
{
    case ADMIN = 'admin';
    case AGENT = 'agent';
    case VAS = 'vas';
    case SALES = 'sales';

}
