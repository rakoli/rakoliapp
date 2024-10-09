<?php

namespace App\Actions\Agent\Shift;

use App\Events\Shift\ShiftClosedEvent;
use App\Models\Location;
use App\Models\Network;
use App\Models\Shift;
use App\Models\ShiftNetwork;
use App\Models\Short;
use App\Utils\Enums\ShiftStatusEnum;
use App\Utils\Enums\ShortTypeEnum;
use App\Utils\Enums\TransactionCategoryEnum;
use App\Utils\Enums\TransactionTypeEnum;
use Lorisleiva\Actions\Concerns\AsAction;

class CloseShift
{
    use AsAction;


    use InteractsWithShift;

    /**
     * @param Shift $shift
     * @param array{closing_balance: float , status: ShiftStatusEnum , description: ?string , notes: ?string , tills: array ,
     *     total_shorts: ?float , short_description: ?string  , income: ?float , expenses: ?float } $data
     * @return mixed
     */
    public function handle(Shift $shift, array $data)
    {

        return runDatabaseTransaction(function () use ($shift, $data) {

            try {

                $shift->updateQuietly([
                    'cash_end' => $data['closing_balance'],
                    'status' => $data['status'],
                    'description' => str($data['description'])->append($shift->description)->toString(),
                    'notes' => str($data['notes'])->append("-------<br/> {$shift->note}")->toString(),
                ]);

                // Location::query()
                //     ->where('code', $shift->location_code)
                //     ->first()
                //     ->updateQuietly([
                //         'balance' => $data['closing_balance']
                //     ]);



                $shiftBalances = shiftBalances(shift: $shift);

                if(isset($data['tills'])){
                    foreach ($data['tills'] as $tillCode => $amount) {

                        // Network::query()
                        //     ->where('location_code', $shift->location_code)
                        //     ->where([
                        //         'code' => $tillCode,
                        //     ])
                        //     ->first()
                        //     ->updateQuietly([
                        //         'balance' => floatval($amount),
                        //     ]);



                        $shiftNetwork = ShiftNetwork::query()
                            ->where('network_code', $tillCode)
                            ->whereBelongsTo($shift, 'shift')
                            ->first();

                        $shiftNetwork->updateQuietly([
                            'balance_new' => $amount
                        ]);


                    }
                }
                
                if ($data['total_shorts']) {

                    $code = $data['short_network_code'] ?? "Cash";

                    Short::query()->whereBelongsTo($shift, "shift")->delete();

                    Short::create([
                        'shift_id' => $shift->id,
                        'business_code' => $shift->business_code,
                        'location_code' => $shift->location_code,
                        'type' => $data['short_type'],
                        'network_code' => $data['short_network_code'],
                        'user_code' => $shift->user_code,
                        'code' => generateCode(name: "short-" . $code, prefixText: "shift-" . $shift->id),
                        "amount" => $data['total_shorts'],
                        "description" => $data['short_description'],
                    ]);

                }

                // $data['location_code'] = $shift->location_code;
                // $data['business_code'] = $shift->business_code;
                // $data['location_new_balance'] = $data['closing_balance'];


                // if ($shiftBalances['expenses'] != $data['expenses'])
                // {
                //     $data['amount'] = $data['expenses'] - $shiftBalances['expenses'] ;

                //     $this->addExpense(
                //         location: $shift->location,
                //         data: $data
                //     );
                // }
                // if ($shiftBalances['income'] != $data['income'])
                // {
                //     $data['amount'] = $data['income'] - $shiftBalances['income'] ;

                //     $this->addIncome(
                //         location: $shift->location,
                //         data: $data
                //     );
                // }


                event(new ShiftClosedEvent(shift: $shift));
            }
            catch (\Exception $exception)
            {
                throw new \Exception($exception->getMessage());
            }

        });


    }



    protected function  addExpense (Location $location, array $data)
    {
        $data['type'] = TransactionTypeEnum::MONEY_OUT->value;

        $data['category'] = TransactionCategoryEnum::EXPENSE;

        return $this->createLocationTransaction(
            data: $data,
            location:  $location,

        );
    }

    protected function addIncome(Location $location, array $data)
    {
        $data['type'] = TransactionTypeEnum::MONEY_IN->value;

        $data['category'] = TransactionCategoryEnum::INCOME;

        return $this->createLocationTransaction(
            data: $data,
            location:  $location,

        );
    }
}
