<?php

namespace App\Utils\Datatables\Agent\Shift;

use App\Models\Transaction;
use App\Utils\Datatables\LakoriDatatable;
use App\Utils\HasDatatable;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class TransactionDatatable implements HasDatatable
{
    use LakoriDatatable;

    public function index(bool $isToday = false): \Illuminate\Http\JsonResponse
    {

        $transactions = Transaction::query()
            ->with('location', 'user')
            ->when($isToday, fn ($query) => $query->whereDate('created_at', Carbon::today()));

        return Datatables::eloquent($transactions)
            ->filter(function ($query) {
                $query->skip(request('start'))->take(request('length'));
            })
            ->order(function ($query) {
                return $query->orderBy('created_at', 'desc');
            })
            ->startsWithSearch()
            ->addIndexColumn()
            ->addColumn('created_at', fn (Transaction $transaction) => $transaction->created_at->format('Y-F-d'))
            ->addColumn('balance_old', fn (Transaction $transaction) => money($transaction->balance_old, currencyCode(), true))
            ->addColumn('user_name', fn (Transaction $transaction) => $transaction->user->full_name)
            ->addColumn('amount', fn (Transaction $transaction) => money($transaction->amount, currencyCode(), true))
            ->addColumn('balance_new', fn (Transaction $transaction) => money($transaction->balance_new, currencyCode(), true))
            ->addColumn('transaction_type', function (Transaction $transaction) {

                $table = new self();

                return $table->status(
                    label: $transaction->type->label(),
                    badgeClass: $transaction->type->color()
                );
            })->addColumn('category_label', function (Transaction $transaction) {

                $table = new self();

                return $table->status(
                    label: $transaction->category->label(),
                    badgeClass: $transaction->category->color()
                );
            })
            ->addColumn('actions', function (Transaction $transaction) {

            })
            ->addColumn('location_name', fn (Transaction $transaction) => $transaction->location->name)

            ->rawColumns(['balance_old', 'balance_new', 'transaction_type', 'category_label', 'actions'])
            ->toJson();
    }

    public function columns(Builder $datatableBuilder): Builder
    {
        return $datatableBuilder->columns([
            Column::make('id')->title('#')->searchable(false)->orderable(),
            Column::make('created_at')->title(__('date'))->searchable()->orderable(),
            Column::make('location.name')->title(__('Location'))->searchable()->orderable(),
            Column::make('user_name')->title(__('user'))->searchable()->orderable(),
            Column::make('balance_old')->title(__('Old Balance').' '.strtoupper(session('currency')))->searchable()->orderable(),
            Column::make('amount')->title(__('Amount Transacted').' '.strtoupper(session('currency')))->searchable()->orderable(),
            Column::make('balance_new')->title(__('New Balance'))->searchable()->orderable(),
            Column::make('transaction_type')->title(__('Type'))->searchable()->orderable(),
            Column::make('category_label')->title(__('category'))->searchable()->orderable(),
        ])
            ->orderBy(0);
    }
}
