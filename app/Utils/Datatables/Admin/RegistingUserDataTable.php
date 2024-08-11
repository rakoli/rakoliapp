<?php

namespace App\Utils\Datatables\Admin;

use App\Models\User;
use App\Utils\Datatables\LakoriDatatable;
use App\Utils\HasDatatable;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class RegistingUserDataTable implements HasDatatable

{
    use LakoriDatatable;

    public function index()
    {

        $users = User::query()->where('type', 'agent')->where('registration_step' , '!=' , 0);

        return Datatables::eloquent($users)

            ->filter(function ($query) {
                $query->skip(request('start'))->take(request('length'));
            })
            ->order(function ($query) {
                return $query->orderBy('id', 'desc');
            })
            ->addIndexColumn()
            ->addColumn('name', fn (User $user) => $user->fname." ".$user->lname)
            ->addColumn('created_at', fn (User $user) => $user->created_at->format('Y-F-d'))
            ->addColumn('action', function (User $user) {

                return (new self())->buttons([
                ]);
            })
            ->rawColumns(['created_at', 'action'])
            ->toJson();
    }
    public function columns(Builder $datatableBuilder): Builder
    {
        return $datatableBuilder->columns([
            Column::make('name')->title(__('Name'))->searchable()->orderable(),
            Column::make('email')->title(__('Email'))->searchable()->orderable(),
            Column::make('phone')->title(__('Phone Number'))->searchable()->orderable(),
            Column::make('registration_step')->title(__('Registration Steps'))->searchable()->orderable(),
            Column::make('created_at')->title(__('Created On'))->searchable()->orderable(),
        ])
            ->responsive(true)
            ->dom('frtilp');
    }
}
