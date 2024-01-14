<?php

namespace App\Http\Controllers\Agent\Transaction;

use App\Http\Controllers\Controller;
use App\Utils\Datatables\Agent\Shift\TransactionDatatable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;

class TransactionsController extends Controller
{
    public function __invoke(Request $request, Builder $datatableBuilder, TransactionDatatable $transactionDatatable): View|JsonResponse
    {

        if ($request->ajax()) {

            return $transactionDatatable->index(isToday: true);
        }

        $dataTableHtml = $transactionDatatable->columns(datatableBuilder: $datatableBuilder);

        return view('agent.agency.transaction.index', [
            'dataTableHtml' => $dataTableHtml,
        ]);
    }
}
