<?php

namespace App\Utils\Datatables\Agent\Shift;

use App\Models\Loan;
use App\Models\LoanPayment;
use App\Utils\Datatables\LakoriDatatable;
use App\Utils\HasDatatable;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class LoanPaymentDatatable implements HasDatatable
{
    use LakoriDatatable;

    public function index(Loan $loan): \Illuminate\Http\JsonResponse
    {

        $transactions = LoanPayment::query()->where('loan_code', $loan->code)->with('user');

        return Datatables::eloquent($transactions)
            ->filter(function ($query) {
                $query->skip(request('start'))->take(request('length'));
            })
            ->order(function ($query) {
                return $query->orderBy('created_at', 'desc');
            })
            ->startsWithSearch()
            ->addIndexColumn()
            ->addColumn('created_at', fn (LoanPayment $record) => $record->created_at->format('Y-F-d'))
            ->addColumn('deposited_at', fn (LoanPayment $record) => $record->deposited_at->format('Y-F-d'))
            ->addColumn('user_name', fn (LoanPayment $record) => $record->user->full_name)
            ->addColumn('amount', fn (LoanPayment $record) => money($record->amount, currencyCode(), true))

            ->rawColumns(['balance', 'user_name'])
            ->toJson();
    }

    public function columns(Builder $datatableBuilder): Builder
    {

        return $datatableBuilder->columns([
            Column::make('id')->title('#')->searchable(false)->orderable(),
            Column::make('created_at')->title(__('Date Received'))->searchable()->orderable(),
            Column::make('deposited_at')->title(__('Date Deposited'))->searchable()->orderable(),
            Column::make('user_name')->title(__('User'))->searchable()->orderable(),
            Column::make('amount')->title(__('amount').' '.strtoupper(session('currency')))->searchable()->orderable(),

        ])
            ->orderBy(0);
    }
}
