<?php

namespace App\Actions\Agent\Shift;

use App\Models\Shift;
use App\Utils\Enums\TransactionTypeEnum;
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

            [$newBalance, $oldBalance] = match ($data['type']) {
                TransactionTypeEnum::MONEY_IN->value => AddTransaction::moneyIn(shift: $shift, data: $data),
                TransactionTypeEnum::MONEY_OUT->value => AddTransaction::moneyOut(shift: $shift, data: $data),
            };

            $this->createShiftTransaction(
                shift: $shift,
                data: $data,
                oldBalance: $oldBalance,
                newBalance: $newBalance,
            );

        });

    }
}
