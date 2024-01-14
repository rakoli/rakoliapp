<?php

namespace App\Utils\Enums;

enum LoanPaymentStatusEnum: string
{
    case UN_PAID = 'un_paid';
    case PARTIALLY = 'partially';
    case FULL_PAID = 'fully_paid';

    public function label(): string
    {
        return match ($this) {

            self::FULL_PAID => 'Fully Paid',
            self::PARTIALLY => 'Partially Paid',
            self::UN_PAID => 'Un paid',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::FULL_PAID => 'badge badge-success',
            self::PARTIALLY => 'badge badge-warning',
            self::UN_PAID => 'badge badge-danger',
        };
    }
}
