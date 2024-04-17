<?php

namespace App\Http\Controllers\Agent\Networks;

use App\Http\Controllers\Controller;
use App\Models\Crypto;
use App\Models\FinancialServiceProvider;
use App\Models\Location;
use App\Utils\Datatables\Agent\Shift\NetworkDatatable;
use Yajra\DataTables\Html\Builder;

class NetworkController extends Controller
{
    public function __invoke(Builder $datatableBuilder, NetworkDatatable $networkDatatable)
    {

        if (\request()->ajax()) {
            return $networkDatatable->index();
        }

        $locations =Location::query()
            ->whereHas('users', fn($query) => $query->where('user_code', auth()->user()->code))
            ->with([
                'networks.agency'])
            ->get();

        $fsps = FinancialServiceProvider::query()->cursor();
        $cryptos = Crypto::query()->cursor();

        return view('agent.agency.network.networks')->with([
            'dataTableHtml' => $networkDatatable->columns($datatableBuilder),
            'locations' => $locations,
            'agencies' => $fsps,
            'cryptos' => $cryptos,
        ]);
    }
}
