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
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\SearchPane;

class TransactionsController extends Controller
{

    public function __invoke(Request $request, Builder $datatableBuilder): View|JsonResponse
    {
        $builder = $datatableBuilder;


        if ($request->ajax()) {


            return (new ShiftTransactionDatatable())->index();
        }

        $dataTableHtml = $builder->columns([
            Column::make('id')->title('#')->searchable(false)->orderable(),
            Column::make('created_at')->title(__('date'))->searchable()->orderable(),
            Column::make('location.name')->title(__('Location'))->searchable()->orderable(),
            Column::make('user_name')->title(__('user'))->searchable()->orderable(),
            Column::make('balance_old')->title(__('Old Balance') . ' ' . strtoupper(session('currency')))->searchable()->orderable(),
            Column::make('amount')->title(__('Amount Transacted') . ' ' . strtoupper(session('currency')))->searchable()->orderable(),
            Column::make('balance_new')->title(__('New Balance'))->searchable()->orderable(),
            Column::make('transaction_type')->title(__('Type'))->searchable()->orderable(),
            Column::make('category')->title(__('Category'))->searchable()->orderable(),
            Column::make('actions')->title(__('Actions')),
        ])
            ->orderBy(0);


        return view('agent.agency.transactions')
            ->with([
                'dataTableHtml' => $dataTableHtml,
            ]);
    }
}
