<?php

namespace App\Actions\Agent\Shift;

use App\Models\Shift;
use App\Utils\Enums\ShiftStatusEnum;
use App\Utils\Enums\TransactionTypeEnum;
use Lorisleiva\Actions\Concerns\AsAction;

class AddShiftTransactionAction
{
    use AsAction;
    use InteractsWithShift;

    /**
     * @param  array{till_code: string,  amount: float , type: string, notes: ?string, description: ?string}  $data
     * @return void
     */
    public function handle(Shift $shift, array $data)
    {

        try {
            if ($shift->status != ShiftStatusEnum::OPEN) {
                throw new \Exception('Shift is closed, and cannot accept a transaction');
            }

            [$newBalance, $oldBalance, $till] = match ($data['type']) {
                TransactionTypeEnum::MONEY_IN->value => AddShiftTransactionAction::moneyIn($data),
                TransactionTypeEnum::MONEY_OUT->value => AddShiftTransactionAction::moneyOut($data),
                default => [0, 0],
            };

            $shift->transactions()
                ->create([
                    'business_code' => $shift->business_code,
                    'location_code' => $shift->location_code,
                    'network_code' => $data['till_code'],
                    'note' => $data['notes'] ?? null,
                    'description' => $data['description'] ?? null,
                    'amount_currency' => currencyCode(),
                    'amount' => $data['amount'],
                    'balance_old' =>  $till->balance_old,
                    'balance_new' => $till->balance_new,
                ]);

        } catch (\Exception $e) {

        }
    }
}
