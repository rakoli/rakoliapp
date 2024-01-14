<?php

namespace App\Actions\Agent\Shift;

use App\Events\Shift\ShiftOpened;
use App\Models\Network;
use App\Models\Shift;
use App\Utils\Enums\ShiftStatusEnum;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class OpenShift
{
    use AsAction;

    public function handle(float $cashAtHand, string $locationCode, ?string $notes = null)
    {

        try {
            DB::beginTransaction();

            if (Shift::query()->where('status', ShiftStatusEnum::OPEN)->exists()) {
                throw new \Exception('Close opened shift to continue');
            }

            // @todo check allowed no of shift for this business per day

            $nos = Shift::query()->latest('created_at')
                ->whereDate('created_at', Carbon::today())
                ->first([
                    "id"
                ])
            ->id;

            tap(Shift::create([
                'user_code' => auth()->user()->code,
                'business_code' => auth()->user()->business_code,
                'location_code' => $locationCode,
                'cash_start' => $cashAtHand,
                'cash_end' => $cashAtHand,
                'currency' => auth()->user()->business->country->currency,
                'notes' => $notes,
                'no' => $nos + 1,

            ]), function (Shift $shift) {

                foreach (Network::query()->cursor() as $network) {

                    $shift->shiftNetworks()->create([
                        'business_code' => $shift->business_code,
                        'location_code' => $shift->location_code,
                        'network_code' => $network->code,
                        'balance_old' => $network->balance,
                        'balance_new' => $network->balance,
                    ]);
                }

                event(new ShiftOpened(shift: $shift));
            });

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            throw new \Exception($e->getMessage());
        }

    }
}
