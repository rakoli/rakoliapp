<?php

namespace App\Actions\Agent\Shift;

use App\Models\Shift;
use App\Models\Transaction;
use App\Utils\Enums\ShiftStatusEnum;
use App\Utils\Enums\TransactionTypeEnum;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class AddTransaction
{
    use AsAction;
    use InteractsWithShift;

    /**
     * @param  array{network_code: string,amount: float, type: string , category: string , notes: ?string , description: ?string }  $data
     *
     * @throws \Throwable
     */
    public function handle(Shift $shift, array $data)
    {


        return runDatabaseTransaction(function ()  use ( $shift, $data) {



                [$newBalance, $oldBalance, $till] = match ($data['type']) {
                    TransactionTypeEnum::MONEY_IN->value => AddTransaction::moneyIn($data),
                    TransactionTypeEnum::MONEY_OUT->value => AddTransaction::moneyOut($data),
                };

                $this->createShiftTransaction(
                    shift: $shift,
                    data: $data,
                    oldBalance: $till->balance_old,
                    newBalance: $till->balance_new
                );


        });


    }
}
