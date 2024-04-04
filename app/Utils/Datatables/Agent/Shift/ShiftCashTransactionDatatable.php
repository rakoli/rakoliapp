<?php

namespace App\Utils\Datatables\Agent\Shift;

use App\Models\Shift;
use App\Models\ShiftCashTransaction;
use App\Utils\Datatables\LakoriDatatable;
use App\Utils\HasDatatable;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class ShiftCashTransactionDatatable implements HasDatatable
{
    use LakoriDatatable;

    public function index(Shift $shift, bool $isToday = false): \Illuminate\Http\JsonResponse
    {
        $transactions = ShiftCashTransaction::query()
            ->whereBelongsTo($shift, 'shift')
            ->with('location', 'user','network.agency');

        return Datatables::eloquent($transactions)
            ->filter(function ($query) {
                $query->skip(request('start'))->take(request('length'));
            })
            ->order(function ($query) {
                return $query->orderBy('created_at', 'desc');
            })
            ->startsWithSearch()
            ->addIndexColumn()
            ->addColumn('created_at', fn (ShiftCashTransaction $transaction) => $transaction->created_at->format('Y-F-d'))
            ->addColumn('balance_old', fn (ShiftCashTransaction $transaction) => money($transaction->balance_old, currencyCode(), true))
            ->addColumn('user_name', fn (ShiftCashTransaction $transaction) => $transaction->user->name())
            ->addColumn('amount', fn (ShiftCashTransaction $transaction) => money($transaction->amount, currencyCode(), true))
            ->addColumn('balance_new', fn (ShiftCashTransaction $transaction) => money($transaction->balance_new, currencyCode(), true))
            ->addColumn('transaction_type', function (ShiftCashTransaction $transaction) {

                $table = new self();

                return $table->status(
                    label: $transaction->type->label(),
                    badgeClass: $transaction->type->color()
                );
            })
            ->addColumn('actions', function (ShiftCashTransaction $transaction) {

            })
            ->addColumn('network_name', fn (ShiftCashTransaction $transaction) => $transaction->network?->agency?->name)

            ->rawColumns(['balance_old', 'balance_new', 'transaction_type', 'actions'])
            ->toJson();
    }

    public function columns(Builder $datatableBuilder): Builder
    {
        return $datatableBuilder
            ->columns([
                Column::make('location.name')->title(__('Location')),
                Column::make('user_name')->title(__('user'))->orderable(),
                Column::make('balance_old')->title(__('Old Balance').' '.strtoupper(session('currency')))->orderable(),
                Column::make('amount')->title(__('Amount Transacted').' '.strtoupper(session('currency')))->orderable(),
                Column::make('balance_new')->title(__('New Balance')),
                Column::make('transaction_type')->title(__('Type'))->orderable(),
            ])
            ->lengthMenu([[5, 10, 20, -1], [5, 10, 20, 'All']])
            ->orderBy(0);
    }
}
