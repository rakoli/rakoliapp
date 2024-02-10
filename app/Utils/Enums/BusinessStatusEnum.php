<?php

namespace App\Utils\Enums;

enum BusinessStatusEnum: string
{
    case ACTIVE = 'active';
    case SUSPENDED = 'suspended';
    case DISABLED = 'disabled';

}
