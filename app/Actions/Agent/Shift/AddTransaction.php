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
     * @param  array{till_code: string,location_code: string,amount: float, type: string , category: string , notes: ?string } $data
     *
     * @throws \Throwable
     */
    public function handle(Shift $shift, array $data)
    {

        try {

            throw_if(condition: ! Shift::query()->where('status', ShiftStatusEnum::OPEN)->exists(),
                exception: new \Exception('You cannot transact without an open shift')
            );

            DB::beginTransaction();

            [$newBalance, $oldBalance] = match ($data['type']) {
                TransactionTypeEnum::MONEY_IN->value => AddTransaction::moneyIn($data),
                TransactionTypeEnum::MONEY_OUT->value => AddTransaction::moneyOut($data),
            };

            Transaction::create([
                'business_code' => auth()->user()->business_code,
                'location_code' => $data['location_code'],
                'user_code' => auth()->user()->code,
                'amount' => $data['amount'],
                'amount_currency' => currencyCode(),
                'type' => $data['type'],
                'category' => $data['category'],
                'balance_old' => $oldBalance,
                'balance_new' => $newBalance,
                'description' => $data['notes'],
            ]);

            $this->createShiftTransaction(
                shift: $shift,
                data: $data,
                oldBalance: $oldBalance,
                newBalance: $newBalance
            );

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();
            throw new \Exception($e->getMessage());
        }

    }
}
