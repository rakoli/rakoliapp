<?php

namespace App\Actions\Agent\Shift;

use App\Events\Shift\AddLoanEvent;
use App\Models\Loan;
use App\Models\Shift;
use App\Utils\Enums\FundSourceEnums;
use App\Utils\Enums\LoanPaymentStatusEnum;
use App\Utils\Enums\LoanTypeEnum;
use App\Utils\Enums\ShiftStatusEnum;
use App\Utils\Enums\TransactionTypeEnum;
use Illuminate\Support\Facades\Log;
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
            Log::info($data);

            throw_if(condition: $shift->status != ShiftStatusEnum::OPEN,
                exception: new \Exception('You cannot transact without an open shift')
            );
            $data['type'] = isset($data['type']) ? $data['type'] : "money_out";
            $loan = Loan::create([
                'business_code' => auth()->user()->business_code,
                'location_code' => $shift->location_code,
                'user_code' => auth()->user()->code,
                'amount' => $data['amount'],
                'network_code' => $data['network_code'],
                'type' => LoanTypeEnum::tryFrom($data['type']),
                'status' => LoanPaymentStatusEnum::UN_PAID,
                'shift_id' => $shift->id,
                'code' => generateCode(name: time(), prefixText: !empty($data['network_code']) ? $data['network_code'] : "CASH"),
                'description' => $data['description'],
                'note' => $data['notes'],
            ]);
            Log::info($loan);

            $source = FundSourceEnums::tryFrom($data['source']);
            Log::info($source);
            if ($source === FundSourceEnums::TILL) {
                [$newBalance, $oldBalance] = match ($data['type']) {
                    LoanTypeEnum::MONEY_IN->value => AddLoan::moneyIn(shift: $shift, data: $data, isLoan: true),
                    LoanTypeEnum::MONEY_OUT->value => AddLoan::moneyOut(shift: $shift, data: $data, isLoan: true),
                };

                $data['type'] = match ($data['type']) {
                    LoanTypeEnum::MONEY_IN->value => TransactionTypeEnum::MONEY_IN,
                    LoanTypeEnum::MONEY_OUT->value => TransactionTypeEnum::MONEY_OUT,
                };
                Log::info("Till");
                Log::info($data);
                $this->createShiftTransaction(
                    shift: $shift,
                    data: $data,
                    oldBalance: $oldBalance,
                    newBalance: $newBalance
                );
            }else {
                [$newBalance, $oldBalance] = match ($data['type']) {
                    LoanTypeEnum::MONEY_IN->value => AddLoan::cashMoneyIn(shift: $shift, data: $data, isLoan: true),
                    LoanTypeEnum::MONEY_OUT->value => AddLoan::cashMoneyOut(shift: $shift, data: $data, isLoan: true),
                };

                $data['type'] = match ($data['type']) {
                    LoanTypeEnum::MONEY_IN->value => TransactionTypeEnum::MONEY_IN,
                    LoanTypeEnum::MONEY_OUT->value => TransactionTypeEnum::MONEY_OUT,
                };
                Log::info("Cash");
                Log::info($data);

                $this->createShiftCashTransaction(
                    shift: $shift,
                    data: $data,
                    oldBalance: $oldBalance,
                    newBalance: $newBalance
                );
            }
            event(new AddLoanEvent(loan: $loan));

        });

    }
}
