<?php

namespace App\Actions\Agent\Shift;

use App\Events\Shift\AddLoanEvent;
use App\Models\Loan;
use App\Models\Shift;
use App\Utils\Enums\FundSourceEnums;
use App\Utils\Enums\LoanPaymentStatusEnum;
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

        Log::info("AddLoan :: Request Data".print_r($data,true));

        return runDatabaseTransaction(function () use ($shift, $data) {
            

            throw_if(condition: $shift->status != ShiftStatusEnum::OPEN,
                exception: new \Exception('You cannot transact without an open shift')
            );
            $loan = Loan::create([
                'business_code' => auth()->user()->business_code,
                'location_code' => $shift->location_code,
                'user_code' => auth()->user()->code,
                'amount' => $data['amount'],
                'network_code' => $data['network_code'],
                'type' => TransactionTypeEnum::tryFrom($data['type']),
                'status' => LoanPaymentStatusEnum::UN_PAID,
                'shift_id' => $shift->id,
                'code' => generateCode(name: time(), prefixText: !empty($data['network_code']) ? $data['network_code'] : "CASH"),
                'description' => $data['description'],
                'note' => $data['notes'],
            ]);
            
            $source = FundSourceEnums::tryFrom($data['source']);
            $type = TransactionTypeEnum::tryFrom($data['type']);
            if ($source === FundSourceEnums::TILL) {
                [$newBalance, $oldBalance] = match ($data['type']) {
                    TransactionTypeEnum::MONEY_IN->value => AddLoan::moneyOut(shift: $shift, data: $data, isLoan: true),
                    TransactionTypeEnum::MONEY_OUT->value => AddLoan::moneyIn(shift: $shift, data: $data, isLoan: true),
                };                
                
                $this->createShiftTransaction(
                    shift: $shift,
                    data: $data,
                    oldBalance: $oldBalance,
                    newBalance: $newBalance
                );
            }else {
                [$newBalance, $oldBalance] = match ($data['type']) {
                    TransactionTypeEnum::MONEY_IN->value => AddLoan::cashMoneyOut(shift: $shift, data: $data, isLoan: true),
                    TransactionTypeEnum::MONEY_OUT->value => AddLoan::cashMoneyIn(shift: $shift, data: $data, isLoan: true),
                };
                
                $this->createShiftCashTransaction(
                    shift: $shift,
                    data: $data,
                    oldBalance: $oldBalance,
                    newBalance: $newBalance
                );
            }
            Log::info(message: "AddLoan :: Update Location Network Balance :: ".print_r($data,true));
            $this->updateBalance(shift: $shift, data: $data);

            event(new AddLoanEvent(loan: $loan));

        });

    }
}
