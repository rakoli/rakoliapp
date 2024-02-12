<?php

namespace App\Http\Controllers\Agent\Shift;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Location;
use App\Models\Shift;
use App\Models\ShiftNetwork;
use App\Utils\Enums\ShiftStatusEnum;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CloseShiftController extends Controller
{
    public function index(Request $request, Shift $shift)
    {

        if (! $shift->status == ShiftStatusEnum::CLOSED) {
            return to_route('agency.shift');
        }

        $locations = $shift->load('location')->location()->get();

        $tills = ShiftNetwork::query()->where('shift_id', $shift->id)
            ->where('balance_new', '>', 0)->with('network.agency');

        $loans = Loan::query()->whereBelongsTo($shift, 'shift')->get()->groupBy(fn (Loan $loan) => $loan->type->label());

        return view('agent.agency.close-shift')->with([
            'tills' => $tills->cursor(),
            'locations' => $locations,
            'shift' => $shift->loadMissing('shorts.network.agency'),
            'loans' => $loans,
            ...shiftBalances($shift),
        ]);
    }

    protected function validateForm(Request $request): array
    {
        return $request->validate(rules: [
            'closing_balance' => 'required|numeric',
            'location_code' => 'nullable',
            'notes' => 'nullable',
            'expenses' => 'nullable',
            'income' => 'nullable',
            'description' => 'required',
            'tills' => 'required',
            'short_type' =>[
                'nullable',
                Rule::requiredIf(fn () => $request->has('total_shorts') && $request->total_shorts > 0),
            ],
            'total_shorts' => [
                'nullable',
                Rule::requiredIf(fn () => $request->has('short_type') && $request->total_shorts > 0),
            ],
            'short_network_code' => [
                'nullable',
                Rule::requiredIf(fn () => $request->has('total_shorts') && $request->total_shorts > 0),
            ],
            'short_description' => [
                'nullable',
                Rule::requiredIf(fn () => $request->has('total_shorts') && $request->total_shorts > 0),
            ],
        ]);
    }

    public function store(Shift $shift, Request $request)
    {

        $validated = $this->validateForm($request);

        $validated['status'] = ShiftStatusEnum::CLOSED;

        try {

            \App\Actions\Agent\Shift\CloseShift::run(
                shift: $shift,
                data: $validated
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
