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

class TransactionsController extends Controller
{

    public function __invoke(Request $request, Builder $datatableBuilder): View|JsonResponse
    {
        $builder = $datatableBuilder;


        if ($request->ajax()) {


            return (new ShiftTransactionDatatable())->index();
        }

        $dataTableHtml = $builder->columns([
            Column::make('id')->title('#')->searchable(),
            Column::make('created_at')->title(__('date'))->searchable(),
            Column::make('location.name')->title(__('Location'))->searchable(),
            Column::make('user_name')->title(__('user'))->searchable(),
            Column::make('balance_old')->title(__('Old Balance') . ' ' . strtoupper(session('currency')))->searchable(),
            Column::make('balance_new')->title(__('New Balance'))->searchable(),
            Column::make('transaction_type')->title(__('Type'))->searchable(),
            Column::make('category')->title(__('Category'))->searchable(),
        ])
            ->orderBy(0, 'desc');


        return view('agent.agency.transactions')
            ->with([
                'dataTableHtml' => $dataTableHtml,
            ]);
    }
}
