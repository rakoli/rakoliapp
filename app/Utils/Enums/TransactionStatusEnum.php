<?php

namespace App\Utils\Enums;

use App\Actions\Shifts\Transaction\DepositTransaction;
use App\Actions\Shifts\Transaction\LoanShiftTransaction;
use App\Actions\Shifts\Transaction\OpenShiftTransaction;
use App\Actions\Shifts\Transaction\TransferShiftTransaction;
use App\Actions\Shifts\Transaction\WithdrawShiftTransaction;

enum TransactionStatusEnum : string
{

    case OPEN = "open";
    case DEPOSIT = "deposit";

    case TRANSFER = "transfer";

    case WITHDRAW = "withdraw";
    case LOAN = "loan";


    public function transact(): string
    {
        return match($this)
        {
            self::OPEN => OpenShiftTransaction::class,
            self::DEPOSIT => DepositTransaction::class,
            self::WITHDRAW => WithdrawShiftTransaction::class,
            self::LOAN => LoanShiftTransaction::class,
            self::TRANSFER => TransferShiftTransaction::class,

        };
    }


}
