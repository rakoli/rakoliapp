<?php

namespace App\Utils\Datatables\Agent\Shift;

use App\Models\Shift;
use App\Utils\Datatables\LakoriDatatable;
use App\Utils\Enums\ShiftStatusEnum;
use App\Utils\HasDatatable;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class ShiftDatatable implements HasDatatable
{
    use LakoriDatatable;

    public function index()
    {

        return Datatables::eloquent(Shift::query()->with(['user', 'location']))
            ->filter(function ($query) {
                $query->skip(request('start'))->take(request('length'));
            })
            ->order(function ($query) {
                return $query->orderBy('created_at', 'desc');
            })
            ->addIndexColumn()
            ->addColumn('created_at', fn (Shift $shift) => $shift->created_at->format('Y-F-d'))
            ->addColumn('user_name', fn (Shift $shift) => $shift->user->full_name)
            ->addColumn('cash_start', fn (Shift $shift) => money($shift->cash_start, currencyCode(), true))
            ->addColumn('cash_end', fn (Shift $shift) => money($shift->cash_end, currencyCode(), true))
            ->addColumn('branch', fn (Shift $shift) => $shift->location->name)
            ->addColumn('action', function (Shift $shift) {

                $actions['Details'] = [
                    'route' => route('agency.shift.show', $shift),
                    'attributes' => 'null',
                ];
                if ($shift->status == ShiftStatusEnum::OPEN) // @todo Authorise this action
                {
                    $actions['Close Shift'] = [
                        'route' => route('agency.shift.close', $shift),
                        'attributes' => null,
                    ];
                }

                $actions['Loans'] = [
                    'route' => route('agency.shift.show.loans', $shift),
                    'attributes' => null,
                ];
                $actions['Tills'] = [
                    'route' => route('agency.shift.till', $shift),
                    'attributes' => null,
                ];


                if ($shift->status == ShiftStatusEnum::INREVIEW) // @todo Authorise this action
                {
                    $actions['Transfer Shift'] = [
                        'route' => "#",
                        "attributes" => null
                    ];
                }
                return ShiftDatatable::make()->buttons($actions);
            })
            ->addColumn('status', function (Shift $shift) {

                $table = ShiftDatatable::make();

                return $shift->status == ShiftStatusEnum::OPEN ? $table->status(
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
            Column::make('no')->title(__('#No'))->searchable()->orderable(),
            Column::make('branch')->title(__('Branch'))->searchable()->orderable(),
            Column::make('user_name')->title(__('user'))->searchable()->orderable(),
            Column::make('cash_start')->title(__('Start Cash').' '.strtoupper(session('currency')))->searchable()->orderable(),
            Column::make('cash_end')->title(__('End Cash').' '.strtoupper(session('currency')))->searchable()->orderable(),
            Column::make('status')->title(__('Status'))->searchable()->orderable(),
            Column::make('action')->title(__('Actions'))->searchable()->orderable(),
        ])
            ->dom('frtilp');
    }
}
