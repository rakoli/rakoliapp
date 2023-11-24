<?php

namespace App\Actions\Agent\Shift;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class AddTransaction
{
    use  AsAction;

    public function handle(array $data)
    {

        try {
            DB::beginTransaction();

            Transaction::create([
                'business_code' => auth()->user()->business_code,
                'location_code' => $data['location_code'],
                'user_code' => auth()->user()->code,
                'amount' => $data['amount'],
                'amount_currency' => currencyCode(),
                'type' => $data['type'],
                'category' => $data['category'],
                'balance_old' => $data['amount'],
                'balance_new' => $data['amount'],
                'description' => $data['notes'],
            ]);

            DB::commit();
        }
        catch (\Exception $e){

            throw new \Exception($e);

            DB::rollBack();
        }

    }


}
