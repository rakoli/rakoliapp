<?php

namespace App\Utils\Datatables\Agent\Shift;

use App\Models\Shift;
use App\Models\ShiftTransferRequest;
use App\Utils\Datatables\LakoriDatatable;
use App\Utils\Enums\ShiftTransferRequestStatusEnum;
use App\Utils\HasDatatable;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class ShiftTransferRequestDatatable implements HasDatatable
{
    use LakoriDatatable;

    public function index()
    {
        return Datatables::eloquent(ShiftTransferRequest::query()->with(['user', 'location']))
            ->filter(function ($query) {
                $query->skip(request('start'))->take(request('length'));
            })
//            ->order(function ($query) {
//                return $query->orderBy('created_at', 'desc');
//            })
//            ->addIndexColumn()
            ->addColumn('created_at', fn (ShiftTransferRequest $shiftTransferRequest) => $shiftTransferRequest->created_at->format('Y-F-d'))
            ->addColumn('user_name', fn (ShiftTransferRequest $shiftTransferRequest) => $shiftTransferRequest->user->name())
            ->addColumn('branch', fn (ShiftTransferRequest $shiftTransferRequest) => $shiftTransferRequest->location->name)
            ->addColumn('action', function (ShiftTransferRequest $shiftTransferRequest) {

                if ($shiftTransferRequest->status == ShiftTransferRequestStatusEnum::PENDING) // @todo Authorise this action
                {
                    $actions['Accept'] = [
                        'route' => route("agency.shift.transfer.request.update",array($shiftTransferRequest,ShiftTransferRequestStatusEnum::ACCEPTED)),
                        'attributes' => null,
                    ];
                    $actions['Reject'] = [
                        'route' => route("agency.shift.transfer.request.update",array($shiftTransferRequest,ShiftTransferRequestStatusEnum::REJECTED)),
                        'attributes' => null,
                    ];
                    return ShiftTransferRequestDatatable::make()->buttons($actions);
                }

            })
            ->addColumn('status', function (ShiftTransferRequest $shiftTransferRequest) {

                $table = ShiftTransferRequestDatatable::make();

                return $shiftTransferRequest->status == ShiftTransferRequestStatusEnum::PENDING ? $table->status(
                    label: $shiftTransferRequest->status->label(),
                    badgeClass: $shiftTransferRequest->status->color(),
                )
                    : $table->status(
                        label: $shiftTransferRequest->status->label(),
                        badgeClass: $shiftTransferRequest->status->color()
                    );
            })
            ->rawColumns(['created_at', 'action', 'status'])
            ->toJson();
    }

    public function columns(Builder $datatableBuilder): Builder
    {
        return $datatableBuilder->columns([
            Column::make('id')->title('#')->searchable(false)->orderable(),
            Column::make('branch')->title(__('Branch'))->searchable()->orderable(),
            Column::make('user_name')->title(__('user'))->searchable()->orderable(),
            Column::make('status')->title(__('Status'))->searchable()->orderable(),
            Column::make('action')->title(__('Actions'))->searchable()->orderable(),
        ])->orderBy(0, 'desc')
            ->dom('frtilp');
    }
}
