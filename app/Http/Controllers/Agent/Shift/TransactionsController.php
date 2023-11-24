<?php

namespace App\Http\Controllers\Agent\Shift;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use App\Utils\Datatables\Agent\Shift\ShiftTransactionDatatable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TransactionsController extends Controller
{

    public function __invoke(Request $request): View|JsonResponse
    {
        $dataTable = new DataTables();
        $builder = $dataTable->getHtmlBuilder();


        if ($request->ajax())
        {
            return (new ShiftTransactionDatatable())->index();
        }


        return view('agent.agency.transactions');
    }
}
