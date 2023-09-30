<?php

namespace App\Utils\Enums;

enum LoanPaymentEnum : string
{

    case UN_PAID = "un paid";
    case PARTIALLY = "partially";
    case FULL_PAID = "fully paid";

}
