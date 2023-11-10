<?php

namespace App\Utils\Enums;

enum AgentRegistrationStepsEnums : int
{

    case VERIFICATION = 1;

    case BUSINESS_INFORMATION = 2;

    case SUBSCRIPTION = 3;

    case COMPLETED = 4;

}
