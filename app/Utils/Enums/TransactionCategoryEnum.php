<?php

namespace App\Utils\Enums;

enum TransactionCategoryEnum : string
{
    case INCOME = "income";
    case EXPENSE = "expense";
    case GENERAL = "general";
}
