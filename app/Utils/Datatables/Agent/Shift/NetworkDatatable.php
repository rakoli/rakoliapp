<?php

namespace App\Utils\Datatables\Agent\Shift;

use App\Models\Network;
use App\Utils\Datatables\LakoriDatatable;
use App\Utils\Enums\NetworkTypeEnum;
use App\Utils\HasDatatable;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class NetworkDatatable implements HasDatatable
{
    use LakoriDatatable;

    public function index(): \Illuminate\Http\JsonResponse
    {

        $transactions = Network::query()->with('location', 'agency', 'loans');

        return Datatables::eloquent($transactions)
            ->filter(function ($query) {
                $query->skip(request('start'))->take(request('length'));
            })
            ->order(function ($query) {
                return $query->orderBy('created_at', 'desc');
            })
            ->startsWithSearch()
            ->addIndexColumn()
            ->addColumn('created_at', fn (Network $network) => $network->created_at->format('Y-F-d'))
            ->addColumn('type', fn (Network $network) => $network->type)
            ->addColumn('location_name', fn (Network $network) => $network->location->name)
            ->addColumn('name', fn (Network $network) => $network->type == NetworkTypeEnum::CRYPTO->value ? $network->crypto?->name  : $network->agency?->name)
            ->addColumn('crypto_balance', fn (Network $network) => $network->crypto_balance)
            ->addColumn('exchange_rate', fn (Network $network) => $network->exchange_rate)
            ->addColumn('balance', fn (Network $network) => $network->type == NetworkTypeEnum::CRYPTO->value ? "~".money($network->crypto_balance * $network->exchange_rate, currencyCode(), true) : money($network->balance, currencyCode(), true))
            ->addColumn('actions', function (Network $network) {
                return NetworkDatatable::make()
                    ->buttons([
                        'Show' => [
                            'route' => route('agency.networks.show', $network),
                            'attributes' => '#',
                        ],
                    ]);
            })
            ->rawColumns(['balance', 'agency_name', 'location_name', 'actions'])
            ->toJson();
    }

    public function columns(Builder $datatableBuilder): Builder
    {
        return $datatableBuilder->columns([

            Column::make('created_at')->title(__('date'))->searchable()->orderable(),
            Column::make('location_name')->title(__('Location'))->searchable()->orderable(),
            Column::make('type')->title(__('Type'))->searchable()->orderable(),
            Column::make('name')->title(__('Agency'))->searchable()->orderable(),
            Column::make('agent_no')->title(__('Agent No'))->searchable()->orderable(),
            Column::make('crypto_balance')->title(__('Crypto Balance'))->searchable()->orderable(),
            Column::make('exchange_rate')->title(__('Exchange Rate'))->searchable()->orderable(),
            Column::make('balance')->title(__('Balance').' '.strtoupper(session('currency')))->searchable()->orderable(),
            Column::make('actions')->title('Actions'),
        ])

            ->orderBy(0);
    }
}
