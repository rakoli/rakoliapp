<?php

namespace App\Http\Controllers\Agent\Shift;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Location;
use App\Models\Shift;
use App\Models\ShiftNetwork;
use App\Utils\Enums\ShiftStatusEnum;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CloseShiftController extends Controller
{
    public function index()
    {

        if (! Shift::query()->where('status', ShiftStatusEnum::OPEN)->exists()) {
            return to_route('agency.shift');
        }

        $locations = Location::query()
           // ->whereHas('users', fn($query) => $query->where('user_code', auth()->user()->code)) //@todo Remove this when implemented
            ->cursor();

        $shift = Shift::query()->where('status', ShiftStatusEnum::OPEN)->first();

        $tills = ShiftNetwork::query()->where('shift_id', $shift->id)
            ->where('balance_new', '>', 0)->with('network.agency');

        $totalBalance = $shift->cash_end + $tills->sum('balance_new');


        $loans = Loan::query()->whereBelongsTo($shift,'shift')->get()->groupBy(fn(Loan $loan) => $loan->type->label() );

        return view('agent.agency.close-shift')->with([
            'tills' => $tills->cursor(),
            'locations' => $locations,
            'shift' => $shift,
            'loans' => $loans,
            'totalBalance' => $totalBalance
        ]);
    }

    public function store(Request $request)
    {
        abort_if(! Shift::query()->where('status', ShiftStatusEnum::OPEN)->exists(), 404, 'No open shift to close');
        $validated = $request->validate(rules: [
            'closing_balance' => 'required|numeric',
            'location_code' => 'required',
            'notes' => 'nullable',
            'description' => 'required',
        ]);

        try {


            \App\Actions\Agent\Shift\CloseShift::run(
                closingBalance: $validated['closing_balance'],
                locationCode: $validated['location_code'],
                notes: $validated['notes'],
            );

            return response()
                ->json([
                    'message' => 'Closed Shift successfully',
                ], 200);

        } catch (ValidationException|\Throwable|\Exception $e) {
            return response()
                ->json([
                    'message' => $e->getMessage(),
                ], 422);
        }

    }
}
