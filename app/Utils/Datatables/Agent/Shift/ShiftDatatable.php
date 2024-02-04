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




        return Datatables::eloquent(Shift::query()->with(['user','location']))
            ->smart()
            ->startsWithSearch()
            ->filter(function ($query){
                $query->skip(request('start'))->take(request('length'));
            })
            ->order(function ($query) {
                return $query->orderBy('status', 'desc');
            })
            ->addIndexColumn()
            ->addColumn('created_at', fn (Shift $shift) => $shift->created_at->format('Y-F-d'))
            ->addColumn('user_name', fn (Shift $shift) => $shift->user->full_name)
            ->addColumn('cash_start', fn (Shift $shift) => money($shift->cash_start, currencyCode(), true))
            ->addColumn('cash_end', fn (Shift $shift) => money($shift->cash_end, currencyCode(), true))
            ->addColumn('branch', fn (Shift $shift) =>  $shift->location->name)
            ->addColumn('action', function (Shift $shift) {
               return ShiftDatatable::make()->buttons([

                    'Details' => [
                        'route' => route('agency.shift.show', $shift),
                        'attributes' => 'null',
                    ],
                    'Close Shift' => [
                        'route' => route('agency.shift.close', $shift),
                        'attributes' => null,
                    ],
                    'Loans' => [
                        'route' => route('agency.shift.till', $shift),
                        'attributes' => null,
                    ],
                    'Tills' => [
                        'route' => route('agency.shift.till', $shift),
                        'attributes' => null,
                    ],
                ]);
            })
            ->addColumn('status', function (Shift $shift) {

                $table = ShiftDatatable::make();

                return $shift->status == ShiftStatusEnum::OPEN ? $table->active() : $table->notActive();
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
