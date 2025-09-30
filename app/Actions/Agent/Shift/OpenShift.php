<?php

namespace App\Actions\Agent\Shift;

use App\Events\Shift\ShiftOpened;
use App\Models\Loan;
use App\Models\Network;
use App\Models\Shift;
use App\Utils\Enums\LoanPaymentStatusEnum;
use App\Utils\Enums\ShiftStatusEnum;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Lorisleiva\Actions\Concerns\AsAction;

class OpenShift
{
    use AsAction;

    public function handle(float $cashAtHand, string $locationCode, ?string $notes = null, ?string $description = null)
    {
        try {
            return runDatabaseTransaction(function () use ($cashAtHand, $locationCode, $notes, $description) {

                if (Shift::query()->where('status', ShiftStatusEnum::OPEN)->exists()) {
                    throw new \Exception('Close opened shift to continue');
                }

                // @todo check allowed no of shift for this business per day

                $nos = Shift::query()->latest('created_at')
                    ->whereDate('created_at', Carbon::today())
                    ->first()?->no;

                return tap(Shift::create([
                    'user_code' => auth()->user()->code,
                    'business_code' => auth()->user()->business_code,
                    'location_code' => $locationCode,
                    'cash_start' => $cashAtHand,
                    'cash_end' => $cashAtHand,
                    'currency' => auth()->user()->business->country->currency,
                    'note' => $notes,
                    'description' => $description,
                    'no' => ($nos ?? 0) + 1,

                ]), function (Shift $shift) {

                    foreach (Network::query()->where('location_code', $shift->location_code)->cursor() as $network) {

                        $shift->shiftNetworks()->create([
                            'business_code' => $shift->business_code,
                            'location_code' => $shift->location_code,
                            'network_code' => $network->code,
                            'balance_old' => $network->balance,
                            'balance_new' => $network->balance,
                        ]);
                    }

                    foreach (Loan::query()->where('location_code', $shift->location_code)->where('status','!=',value: LoanPaymentStatusEnum::FULL_PAID)->cursor() as $loan) {
                        Log::info($loan);
                        $loan->update(['shift_id' => $shift->id]);
                    }

                    event(new ShiftOpened(shift: $shift));
                });

            });
        } catch (\Exception $e) {
            Log::error('OpenShift Error: ' . $e->getMessage());
            Log::error('OpenShift Trace: ' . $e->getTraceAsString());
            throw $e;
        }
    }
}
