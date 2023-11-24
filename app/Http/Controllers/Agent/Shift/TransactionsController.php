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


        if ($request->ajax()) {
            return (new ShiftTransactionDatatable())->index();
        }

        $dataTableHtml = $builder->columns([
            ['data' => 'created_at', 'title' => __('Date')],
            ['data' => 'location', 'title' => __('Location')],
            ['data' => 'user_name', 'title' => __('user')],
            ['data' => 'balance_old', 'title' => __('Old Balance') . ' ' . strtoupper(session('currency'))],
            ['data' => 'balance_new', 'title' => __('New Balance')],
            ['data' => 'type', 'title' => __('Type')],
            ['data' => 'category', 'title' => __('Category')],
        ])->orderBy(0, 'desc');


        return view('agent.agency.transactions')
            ->with([
                'dataTableHtml' => $dataTableHtml,
            ]);
    }
}
