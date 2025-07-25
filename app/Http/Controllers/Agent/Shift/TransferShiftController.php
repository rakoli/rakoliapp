<?php

namespace App\Http\Controllers\Agent\Shift;

use App\Actions\Agent\Shift\OpenShift;
use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Shift;
use App\Models\ShiftTransferRequest;
use App\Utils\Datatables\Agent\Shift\ShiftTransferRequestDatatable;
use App\Utils\Enums\ShiftStatusEnum;
use App\Utils\Enums\ShiftTransferRequestStatusEnum;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Html\Builder;

class TransferShiftController extends Controller
{

    public function index(Builder $datatableBuilder, ShiftTransferRequestDatatable $shiftTransferRequestDatatable)
    {
        if (\request()->ajax()) {
            return $shiftTransferRequestDatatable->index();
        }

        return view('agent.agency.shift.shift_transfer_requests', [
            'dataTableHtml' => $shiftTransferRequestDatatable->columns(datatableBuilder: $datatableBuilder),
        ]);
    }

    public function updateStatus($shiftTransferRequest, $status)
    {
        $shiftTransferRequest = ShiftTransferRequest::find($shiftTransferRequest);
        if($status == ShiftTransferRequestStatusEnum::ACCEPTED->value){
            
            $shift = Shift::where('status', ShiftStatusEnum::OPEN)->first();
            if ($shift) {
                return redirect()->back()->with('error','Please close open shift.');
            }
    
            OpenShift::run(
                cashAtHand: Location::query()->where('code', $shiftTransferRequest->location_code)->pluck('balance')->first(),
                locationCode: $shiftTransferRequest->location_code,
                notes: "",
                description: ""
            );

            $shiftTransferRequest->update(['status' => ShiftTransferRequestStatusEnum::ACCEPTED]);
            
            return redirect()->route('agency.shift.transfer.request')->with('success','Transfer Request has been accepted successfully.');

        } else if($status == ShiftTransferRequestStatusEnum::REJECTED->value){

            $shiftTransferRequest->update(['status' => ShiftTransferRequestStatusEnum::REJECTED]);
            
            return redirect()->route('agency.shift.transfer.request')->with('success','Transfer Request has been rejected successfully.');

        }
        return redirect()->route('agency.shift.transfer.request')->with('error','Status is not valid');
    }
    protected function validateForm(Request $request): array
    {
        return $request->validate(rules: [
            'transfer_user_code' => 'required',
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

        $validated['status'] = ShiftStatusEnum::INREVIEW;

        try {

            \App\Actions\Agent\Shift\AddShiftTransferRequestAction::run(
                shift: $shift,
                data: $validated
            );

            \App\Actions\Agent\Shift\CloseShift::run(
                shift: $shift,
                data: $validated
            );

            return response()
                ->json([
                    'message' => __('general.LBL_SHIFT_CLOSED_SUCCESSFULLY'),
                ], 200);

        } catch (ValidationException|\Throwable|\Exception $e) {
            return response()
                ->json([
                    'message' => $e->getMessage(),
                ], 422);
        }

    }
}
