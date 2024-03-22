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
            ->order(function ($query) {
                return $query->orderBy('created_at', 'desc');
            })
            ->addIndexColumn()
            ->addColumn('created_at', fn (ShiftTransferRequest $shift) => $shift->created_at->format('Y-F-d'))
            ->addColumn('user_name', fn (ShiftTransferRequest $shift) => $shift->user->name())
            ->addColumn('branch', fn (ShiftTransferRequest $shift) => $shift->location->name)
            ->addColumn('action', function (ShiftTransferRequest $shift) {

                $actions['Details'] = [
                    'route' => "#",
                    'attributes' => 'null',
                ];
                if ($shift->status == ShiftTransferRequestStatusEnum::PENDING) // @todo Authorise this action
                {
                    $actions['Accept'] = [
                        'route' => "#",
                        'attributes' => null,
                    ];
                    $actions['Reject'] = [
                        'route' => "#",
                        'attributes' => null,
                    ];

                }

                return ShiftTransferRequestDatatable::make()->buttons($actions);
            })
            ->addColumn('status', function (ShiftTransferRequest $shift) {

                $table = ShiftTransferRequestDatatable::make();

                return $shift->status == ShiftTransferRequestStatusEnum::PENDING ? $table->status(
                    label: $shift->status->label(),
                    badgeClass: $shift->status->color(),
                )
                    : $table->status(
                        label: $shift->status->label(),
                        badgeClass: $shift->status->color()
                    );
            })
            ->rawColumns(['created_at', 'action', 'status'])
            ->toJson();
    }

    public function columns(Builder $datatableBuilder): Builder
    {
        return $datatableBuilder->columns([
            Column::make('branch')->title(__('Branch'))->searchable()->orderable(),
            Column::make('user_name')->title(__('user'))->searchable()->orderable(),
            Column::make('status')->title(__('Status'))->searchable()->orderable(),
            Column::make('action')->title(__('Actions'))->searchable()->orderable(),
        ])
            ->dom('frtilp');
    }
}
