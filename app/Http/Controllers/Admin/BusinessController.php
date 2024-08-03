<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Utils\Datatables\Admin\UserDataTable;
use Yajra\DataTables\Html\Builder;

class BusinessController extends Controller
{
    public function listbusiness()
    {

        return view('admin.business.listbusiness');
    }

    public function listusers()
    {
        return view('admin.business.listusers');
    }
    public function registeringuser(Builder $datatableBuilder, UserDataTable $userDatatable)
    {
        if (\request()->ajax()) {
            return ($userDatatable->index());
        }

        return view('admin.business.registeringusers',[
            'dataTableHtml' => $userDatatable->columns(datatableBuilder: $datatableBuilder),
        ]);
    }
}
