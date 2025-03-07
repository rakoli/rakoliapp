<?php

namespace App\Actions\Agent\Shift;

use App\Models\Shift;
use App\Utils\Enums\TransactionTypeEnum;
use Illuminate\Support\Facades\Log;
use Lorisleiva\Actions\Concerns\AsAction;

class TransferBalance
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

            $data['source'] = "TILL";
            $data['type'] = "OUT";
            [$newBalance, $oldBalance] = match ($data['type']) {
                TransactionTypeEnum::MONEY_IN->value => AddTransaction::moneyOut(shift: $shift, data: $data),
                TransactionTypeEnum::MONEY_OUT->value => AddTransaction::moneyIn(shift: $shift, data: $data),
            };
            Log::info(print_r($data,true));
            $this->createShiftTransaction(
                shift: $shift,
                data: $data,
                oldBalance: $oldBalance,
                newBalance: $newBalance,
            );
            $this->updateBalance(shift: $shift, data: $data);

            sleep(1);
            
            $data['source'] = "TILL";
            $data['type'] = "IN";
            $data['network_code'] = $data['destination_till'];
            [$newCashBalance, $oldCashBalance] = match ($data['type']) {
                TransactionTypeEnum::MONEY_IN->value => AddTransaction::moneyOut(shift: $shift, data: $data),
                TransactionTypeEnum::MONEY_OUT->value => AddTransaction::moneyIn(shift: $shift, data: $data),
            };
            Log::info(print_r($data,true));
            $this->createShiftTransaction(
                shift: $shift,
                data: $data,
                oldBalance: $oldCashBalance,
                newBalance: $newCashBalance,
            );

            $this->updateBalance(shift: $shift, data: $data);

        });

    }
}
