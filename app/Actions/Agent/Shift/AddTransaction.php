<?php

namespace App\Actions\Agent\Shift;

use App\Models\Shift;
use App\Utils\Enums\TransactionTypeEnum;
use Illuminate\Support\Facades\Log;
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

        return runDatabaseTransaction(function () use ($shift, $data) {
            Log::info(print_r($data,true));

            [$newBalance, $oldBalance] = match ($data['type']) {
                TransactionTypeEnum::MONEY_IN->value => AddTransaction::moneyIn(shift: $shift, data: $data),
                TransactionTypeEnum::MONEY_OUT->value => AddTransaction::moneyOut(shift: $shift, data: $data),
            };
            Log::info("Till Balance New: ".$newBalance." Till cash balance: ".$oldBalance);

            $this->createShiftTransaction(
                shift: $shift,
                data: $data,
                oldBalance: $oldBalance,
                newBalance: $newBalance,
            );

            [$newCashBalance, $oldCashBalance] = match ($data['type']) {
                TransactionTypeEnum::MONEY_IN->value => AddTransaction::cashMoneyOut(shift: $shift, data: $data),
                TransactionTypeEnum::MONEY_OUT->value => AddTransaction::cashMoneyIn(shift: $shift, data: $data),
            };
            Log::info(print_r($data,true));
            Log::info("Cash Balance New: ".$newCashBalance." old cash balance: ".$oldCashBalance);

            $this->createShiftCashTransaction(
                shift: $shift,
                data: $data,
                oldBalance: $oldCashBalance,
                newBalance: $newCashBalance,
            );

        });

    }
}
