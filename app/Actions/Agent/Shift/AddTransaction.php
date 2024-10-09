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
        Log::info("AddTransaction :: Request Data".print_r($data,true));
        return runDatabaseTransaction(function () use ($shift, $data) {

            [$newBalance, $oldBalance] = match ($data['type']) {
                TransactionTypeEnum::MONEY_IN->value => AddTransaction::moneyIn(shift: $shift, data: $data),
                TransactionTypeEnum::MONEY_OUT->value => AddTransaction::moneyOut(shift: $shift, data: $data),
            };

            $data['source'] = "TILL";
            $data['type'] = $data['type'] == "IN" ? "OUT" : "IN";

            $this->createShiftTransaction(
                shift: $shift,
                data: $data,
                oldBalance: $oldBalance,
                newBalance: $newBalance,
            );

            $this->updateBalance(shift: $shift, data: $data);

            $data['source'] = "CASH";
            $data['type'] = $data['type'] == "IN" ? "OUT" : "IN";
            
            [$newCashBalance, $oldCashBalance] = match ($data['type']) {
                TransactionTypeEnum::MONEY_IN->value => AddTransaction::cashMoneyOut(shift: $shift, data: $data),
                TransactionTypeEnum::MONEY_OUT->value => AddTransaction::cashMoneyIn(shift: $shift, data: $data),
            };

            $this->createShiftCashTransaction(
                shift: $shift,
                data: $data,
                oldBalance: $oldCashBalance,
                newBalance: $newCashBalance,
            );

            $this->updateBalance(shift: $shift, data: $data);


        });

    }
}
