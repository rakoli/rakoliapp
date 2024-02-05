<?php

namespace App\Actions\Agent\Shift;

use App\Events\Shift\AddLoanEvent;
use App\Models\Loan;
use App\Models\Shift;
use App\Utils\Enums\LoanPaymentStatusEnum;
use App\Utils\Enums\LoanTypeEnum;
use App\Utils\Enums\ShiftStatusEnum;
use App\Utils\Enums\TransactionTypeEnum;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class AddLoan
{
    use AsAction;
    use InteractsWithShift;

    /**
     * @throws \Throwable
     */
    public function handle(Shift $shift, array $data): mixed
    {

        return runDatabaseTransaction(function () use ($shift, $data) {

            throw_if(condition: $shift->status != ShiftStatusEnum::OPEN,
                exception: new \Exception('You cannot transact without an open shift')
            );

            DB::beginTransaction();

            $loan = Loan::create([
                'business_code' => auth()->user()->business_code,
                'location_code' => $shift->location_code,
                'user_code' => auth()->user()->code,
                'amount' => $data['amount'],
                'network_code' => $data['network_code'],
                'type' => LoanTypeEnum::tryFrom($data['type']),
                'status' => LoanPaymentStatusEnum::UN_PAID,
                'shift_id' => $shift->id,
                'code' => generateCode(name: time(), prefixText: $data['network_code']),
                'description' => $data['description'],
                'note' => $data['notes'],
            ]);

            [$newBalance, $oldBalance] = match ($data['type']) {
                LoanTypeEnum::MONEY_IN->value => AddLoan::moneyIn($data, true),
                LoanTypeEnum::MONEY_OUT->value => AddLoan::moneyOut($data, true),
            };

            $data['type'] = match ($data['type']) {
                LoanTypeEnum::MONEY_IN->value => TransactionTypeEnum::MONEY_IN,
                LoanTypeEnum::MONEY_OUT->value => TransactionTypeEnum::MONEY_OUT,
            };

            $this->createShiftTransaction(
                shift: $shift,
                data: $data,
                oldBalance: $oldBalance,
                newBalance: $newBalance
            );

            event(new AddLoanEvent(loan: $loan));

        });

    }
}
