<?php

namespace App\Actions\Agent\Shift;

use App\Models\Shift;
use App\Models\Transaction;
use App\Utils\Enums\TransactionTypeEnum;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class AddExpenseTransaction
{
    use AsAction;
    use InteractsWithShift;

    /**
     * @param  array{ amount: float, type: string , category: string , notes: ?string  , description: ?string }  $data
     *
     * @throws \Throwable
     */
    public function handle(Shift $shift, array $data): void
    {

        try {

            DB::beginTransaction();

            [$newBalance, $oldBalance, $till] = match ($data['type']) {
                TransactionTypeEnum::MONEY_IN->value => AddExpenseTransaction::moneyIn($data),
                TransactionTypeEnum::MONEY_OUT->value => AddExpenseTransaction::moneyOut($data),
            };

            Transaction::create([
                'business_code' => $shift->business_code,
                'location_code' => $shift->location_code,
                'user_code' => auth()->user()->code,
                'amount' => $data['amount'],
                'amount_currency' => currencyCode(),
                'type' => $data['type'],
                'category' => $data['category'],
                'balance_old' => $oldBalance,
                'balance_new' => $newBalance,
                'description' => $data['description'],
                'note' => $data['notes'],
            ]);

            $this->createShiftTransaction(
                shift: $shift,
                data: $data,
                oldBalance: $till->balance_old,
                newBalance: $till->balance_old
            );

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }

    }
}
