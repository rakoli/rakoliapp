<?php

namespace App\Utils\Datatables\Agent\Shift;

use App\Models\Crypto;
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
            ->addColumn('network_name', function (Network $network) { 
                if($network->type == NetworkTypeEnum::CRYPTO->value){
                    return $network->crypto?->name;
                } else {
                    return '<img src="'.$network->agency?->getLogo().'" class="img-flag"> '.$network->agency?->name;
                }
            })
//            ->addColumn('crypto_balance', fn (Network $network) => $network->crypto_balance)
//            ->addColumn('exchange_rate', fn (Network $network) => $network->exchange_rate)
//            ->addColumn('balance', fn (Network $network) => $network->type == NetworkTypeEnum::CRYPTO->value ? "~".money($network->crypto_balance * $network->exchange_rate, currencyCode(), true) : money($network->balance, currencyCode(), true))
            ->addColumn('balance_combined', function (Network $network) {
                if ($network->type == NetworkTypeEnum::CRYPTO->value){
                    return "~".money(Crypto::convertCryptoToFiat($network->crypto->symbol,'TZS',$network->crypto_balance), currencyCode(), true).'<br>'.$network->crypto->symbol." $network->crypto_balance";
                }
                return money($network->balance, currencyCode(), true);
            })
            ->addColumn('actions', function (Network $network) {
                return NetworkDatatable::make()
                    ->buttons([
                        'Show' => [
                            'route' => route('agency.networks.show', $network),
                            'attributes' => '#',
                        ],
                    ]);
            })
            ->rawColumns(['balance', 'network_name', 'location_name', 'actions','balance_combined'])
            ->toJson();
    }

    public function columns(Builder $datatableBuilder): Builder
    {
        return $datatableBuilder->columns([

            Column::make('created_at')->title(__('general.LBL_DATE'))->searchable()->orderable(),
            Column::make('location_name')->title(__('general.LBL_LOCATION'))->searchable()->orderable(),
            Column::make('type')->title(__('general.LBL_TYPE'))->searchable()->orderable(),
            Column::make('name')->title(__('general.LBL_TILL_NAME'))->searchable()->orderable(),
            Column::make('network_name')->title(__('general.LBL_AGENCY'))->searchable()->orderable(),
            Column::make('agent_no')->title(__('general.LBL_AGENT_NO'))->searchable()->orderable(),
            Column::make('balance_combined')->title(__('general.LBL_BALANCE').' '.strtoupper(session('currency')))->searchable()->orderable(),
            Column::make('actions')->title('general.LBL_ACTIONS'),
        ])
            ->responsive(true)
            ->orderBy(0);
    }
}
