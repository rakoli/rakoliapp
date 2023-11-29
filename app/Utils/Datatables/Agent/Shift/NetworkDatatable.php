<?php

namespace App\Utils\Datatables\Agent\Shift;

use App\Models\Network;
use App\Models\Shift;
use App\Models\ShiftNetwork;
use App\Models\Transaction;
use App\Utils\Datatables\LakoriDatatable;
use App\Utils\Enums\ShiftStatusEnum;
use App\Utils\Enums\TransactionTypeEnum;
use App\Utils\HasDatatable;
use Illuminate\Support\HtmlString;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class NetworkDatatable implements HasDatatable
{
    use LakoriDatatable;


    public function index(): \Illuminate\Http\JsonResponse
    {

        $transactions = Network::query()->with('location','agency','loans');

        return Datatables::eloquent($transactions)
            ->filter(function ($query) {
                $query->skip(request('start'))->take(request('length'));
            })
            ->order(function ($query) {
                return $query->orderBy('created_at', 'desc');
            })
            ->startsWithSearch()
            ->addIndexColumn()
            ->addColumn('created_at', fn(Network $record) => $record->created_at->format('Y-F-d'))
            ->addColumn('location_name', fn(Network $record) => $record->location->name)
            ->addColumn('agency_name', fn(Network $record) => $record->agency->name)
            ->addColumn('balance', fn(Network $record) => money($record->balance, currencyCode(), true))
            ->rawColumns(['balance','agency_name','location_name'])
            ->toJson();
    }

    public function columns(Builder $datatableBuilder): Builder
    {
        return $datatableBuilder->columns([
            Column::make('id')->title('#')->searchable(false)->orderable(),
            Column::make('created_at')->title(__('date'))->searchable()->orderable(),
            Column::make('location_name')->title(__('Location'))->searchable()->orderable(),
            Column::make('name')->title(__('network Name'))->searchable()->orderable(),
            Column::make('agency_name')->title(__('Agency'))->searchable()->orderable(),
            Column::make('agent_no')->title(__('Agent No'))->searchable()->orderable(),
            Column::make('balance')->title(__('Balance') . ' ' . strtoupper(session('currency')))->searchable()->orderable(),
        ])
            ->orderBy(0);
    }
}
