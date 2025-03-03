<?php

namespace App\Utils\Datatables\Admin;

use App\Models\Business;
use App\Utils\Datatables\LakoriDatatable;
use App\Utils\HasDatatable;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class BusinessDataTable implements HasDatatable

{
    use LakoriDatatable;

    public function index()
    {

        $users = Business::query()->where('type', 'agent')->WhereNotNull('package_code');

        return Datatables::eloquent($users)

            ->filter(function ($query) {
                $query->skip(request('start'))->take(request('length'));
            })
            ->order(function ($query) {
                return $query->orderBy('id', 'desc');
            })
            ->addIndexColumn()
            ->addColumn('bussiness_name', fn (Business $business) => $business->business_name)
            ->addColumn('is_trial', fn (Business $business) => $business->is_trial ? "Trial" : "Paid")
            ->addColumn('balance', fn (Business $business) => money($business->balance, currencyCode(), true))
            ->addColumn('created_at', fn (Business $business) => $business->created_at->format('Y-F-d'))
            ->addColumn('action', fn (Business $business) => (new self())->buttons([
                'Reset' => [
                    'route' => route('admin.business.resetbusiness', [
                        'code' => $business->code
                    ]),
                    'attributes' => '',
                ],
            ]))
            ->rawColumns(['created_at', 'action'])
            ->toJson();
    }
    public function columns(Builder $datatableBuilder): Builder
    {
        return $datatableBuilder->columns([
            Column::make('bussiness_name')->title(__('Bussiness Name'))->searchable()->orderable(),
            Column::make('business_email')->title(__('Email'))->searchable()->orderable(),
            Column::make('business_phone_number')->title(__('Phone Number'))->searchable()->orderable(),
            Column::make('status')->title(__('Status'))->searchable()->orderable(),
            Column::make('is_trial')->title(__('Subscription'))->searchable()->orderable(),
            Column::make('balance')->title(__('Balance'))->searchable()->orderable(),
            Column::make('created_at')->title(__('Created On'))->searchable()->orderable(),
            Column::make('action')->title(__('Actions'))->searchable()->orderable(),
        ])
            ->responsive(true)
            ->dom('frtilp');
    }
}
