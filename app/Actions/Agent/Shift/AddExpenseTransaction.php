<?php

namespace App\Actions\Agent\Shift;

use App\Events\Shift\LocationBalanceUpdate;
use App\Models\Location;
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


            $location = Location::query()->where('code', $shift->location_code)->first();

            $balance =  $location->balance;

            Transaction::create([
                'business_code' => $shift->business_code,
                'location_code' => $shift->location_code,
                'user_code' => auth()->user()->code,
                'amount' => $data['amount'],
                'amount_currency' => currencyCode(),
                'type' => $data['type'],
                'category' => $data['category'],
                'balance_old' => $balance,
                'balance_new' => $balance - $data['amount'],
                'description' => $data['description'] ?? null,
                'note' => $data['notes'] ?? null,
            ]);


            $location->updateQuietly([
                'balance' => $balance - $data['amount'],
            ]);


            $shift->updateQuietly([
                'cash_end' => $shift->cash_end - $data['amount']
            ]);



            event(new LocationBalanceUpdate(location: $location , amount: $data['amount']));


            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }

    }
}
