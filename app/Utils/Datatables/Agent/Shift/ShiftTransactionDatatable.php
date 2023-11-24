<?php

namespace App\Utils\Datatables\Agent\Shift;

use App\Models\Shift;
use App\Models\ShiftNetwork;
use App\Models\Transaction;
use App\Utils\Datatables\LakoriDatatable;
use Yajra\DataTables\Facades\DataTables;

class ShiftTransactionDatatable
{
    use LakoriDatatable;


    public function index(): \Illuminate\Http\JsonResponse
    {

        $transactions = Transaction::query();

        return Datatables::eloquent($transactions)
            ->filter(function ($query) {
                $query->skip(request('start'))->take(request('length'));
            })
            ->order(function ($query) {
                return $query->orderBy('id', 'desc');
            })
            ->startsWithSearch()
            ->addIndexColumn()
            ->addColumn('created_at', fn(Transaction $shift) => $shift->created_at->format('Y-F-d'))
            ->addColumn('balance_old', fn(Transaction $transaction) => money($transaction->balance_old, currencyCode()))
            ->addColumn('user_name', fn(Transaction $transaction) => $transaction->user->full_name)
            ->addColumn('amount', fn(Transaction $transaction) => money($transaction->amount, currencyCode()))
            ->addColumn('balance_new', fn(Transaction $transaction) => money($transaction->balance_new, currencyCode()))
            ->addColumn('type', fn(Transaction $transaction) => $transaction->type->color())
            ->addColumn('category', fn(Transaction $transaction) => $transaction->category->value)
            ->rawColumns(['balance_old','balance_new','type','category'])
            ->toJson();
    }

}
