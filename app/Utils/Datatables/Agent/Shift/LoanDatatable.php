<?php

namespace App\Utils\Datatables\Agent\Shift;

use App\Models\Loan;
use App\Utils\Datatables\LakoriDatatable;
use App\Utils\HasDatatable;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class LoanDatatable implements HasDatatable
{
    use LakoriDatatable;

    public function index(): \Illuminate\Http\JsonResponse
    {

        $transactions = Loan::query()->with('location', 'shift', 'network.agency', 'user');

        return Datatables::eloquent($transactions)
            ->filter(function ($query) {
                $query->skip(request('start'))->take(request('length'));
            })
            ->order(function ($query) {
                return $query->orderBy('created_at', 'desc');
            })
            ->startsWithSearch()
            ->addIndexColumn()
            ->addColumn('created_at', fn (Loan $record) => $record->created_at->format('Y-F-d'))
            ->addColumn('location_name', fn (Loan $record) => $record->location->name)
            ->addColumn('user_name', fn (Loan $record) => $record->user->full_name)
            ->addColumn('agency_name', fn (Loan $record) => $record->network->agency->name)
            ->addColumn('status', function (Loan $record) {

                $table = new self();

                return $table->status(
                    label: $record->status->label(),
                    badgeClass: $record->status->color()
                );
            })
            ->addColumn('type', function (Loan $record) {

                $table = new self();

                return $table->status(
                    label: $record->type->label(),
                    badgeClass: $record->type->color()
                );
            })
            ->addColumn('action', fn (Loan $loan) => (new self())->buttons([

                'pay' => [
                    'route' => route('agency.loans.show', [
                        "shift" => $loan->shift ,
                        "loan" => $loan
                    ]),
                    'attributes' => '',
                ],
            ]))
            ->addColumn('amount', fn (Loan $record) => money($record->amount, currencyCode(), true))
            ->addColumn('balance', fn (Loan $record) => money($record->balance, currencyCode(), true))
            ->rawColumns(['balance', 'agency_name', 'action', 'location_name', 'user_name', 'type', 'status'])
            ->toJson();
    }

    public function columns(Builder $datatableBuilder): Builder
    {

        return $datatableBuilder->columns([
            Column::make('id')->title('#')->searchable(false)->orderable(),
            Column::make('created_at')->title(__('date'))->searchable()->orderable(),
            Column::make('location_name')->title(__('Location'))->searchable()->orderable(),
            Column::make('user_name')->title(__('User'))->searchable()->orderable(),
            Column::make('agency_name')->title(__('Agency'))->searchable()->orderable(),
            Column::make('status')->title(__('status'))->searchable()->orderable(),
            Column::make('type')->title(__('type'))->searchable()->orderable(),
            Column::make('amount')->title(__('amount').' '.strtoupper(session('currency')))->searchable()->orderable(),
            Column::make('balance')->title(__('balance').' '.strtoupper(session('currency')))->searchable()->orderable(),
            Column::make('action')->data('action')->title(__('action')),

        ])

            ->orderBy(0);
    }
}
