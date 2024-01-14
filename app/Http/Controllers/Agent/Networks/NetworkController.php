<?php

namespace App\Http\Controllers\Agent\Networks;

use App\Http\Controllers\Controller;
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

        $locations = Location::query()->cursor();

        $fsps = FinancialServiceProvider::query()->cursor();

        return view('agent.agency.network.networks')->with([
            'dataTableHtml' => $networkDatatable->columns($datatableBuilder),
            'locations' => $locations,
            'agencies' => $fsps,
        ]);
    }
}
