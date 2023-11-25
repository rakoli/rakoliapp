<?php

namespace App\Http\Controllers\Agent\Shift;

use App\Http\Controllers\Controller;
use App\Utils\Datatables\Agent\Shift\NetworkDatatable;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;

class NetworkController extends Controller
{
    public function __invoke(Builder $datatableBuilder, NetworkDatatable $networkDatatable)
    {

        if (\request()->ajax())
        {
            return  $networkDatatable->index();
        }

        return view('agent.agency.networks')->with([
            'dataTableHtml' => $networkDatatable->columns($datatableBuilder)
        ]);
    }
}
