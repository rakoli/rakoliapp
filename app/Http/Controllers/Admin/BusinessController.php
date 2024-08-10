<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Utils\Datatables\Admin\BusinessDataTable;
use App\Utils\Datatables\Admin\RegistingUserDataTable;
use App\Utils\Datatables\Admin\UserDataTable;
use Yajra\DataTables\Html\Builder;

class BusinessController extends Controller
{
    public function listbusiness(Builder $datatableBuilder, BusinessDataTable $businessDataTable)
    {
        if (\request()->ajax()) {
            return ($businessDataTable->index());
        }
        return view('admin.business.listbusiness',[
            'dataTableHtml' => $businessDataTable->columns(datatableBuilder: $datatableBuilder),
        ]);
    }

    public function listusers(Builder $datatableBuilder, UserDataTable $userDatatable)
    {
        if (\request()->ajax()) {
            return ($userDatatable->index());
        }
        return view('admin.business.listusers',[
            'dataTableHtml' => $userDatatable->columns(datatableBuilder: $datatableBuilder),
        ]);

    }
    public function registeringuser(Builder $datatableBuilder, RegistingUserDataTable $userDatatable)
    {
        if (\request()->ajax()) {
            return ($userDatatable->index());
        }

        return view('admin.business.registeringusers',[
            'dataTableHtml' => $userDatatable->columns(datatableBuilder: $datatableBuilder),
        ]);
    }
}
