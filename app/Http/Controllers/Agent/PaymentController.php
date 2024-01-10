<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PaymentController extends Controller
{
    public function payments(Request $request)
    {
        $user = \auth()->user();
        $dataTable = new DataTables();
        $builder = $dataTable->getHtmlBuilder();
        $orderBy = null;
        $orderByFilter = null;

        if ($request->get('order_by')) {
            $orderBy = ['order_by' => $request->get('order_by')];
            $orderByFilter = $request->get('order_by');
        }
        $roles = Transaction::where('business_code', $user->business_code)->orderBy('id', 'desc');
        $balance = Business::where('code', $user->business_code)->get();

        if (request()->ajax()) {
            return \Yajra\DataTables\Facades\DataTables::eloquent($roles)
            // ->addColumn('actions', function(Transaction $role) {
            //     $content = '<button class="btn btn-secondary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#edit_method_modal" onclick="editClicked('.$role->id.')">'.__("Edit").'</button>';
            //     $content .= '<button class="btn btn-secondary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#delete_method_modal" onclick="deleteClicked('.$role->id.')">'.__("Delete").'</button>';
            //     return $content;
            // })
            // ->rawColumns(['actions'])
                ->addIndexColumn()
                ->toJson();
        }

        // DataTable
        $dataTableHtml = $builder->columns([
            ['data' => 'id', 'title' => __('ID')],
            ['data' => 'business_code', 'title' => __('Business Code')],
            ['data' => 'type', 'title' => __('Type')],
            ['data' => 'category', 'title' => __('Category')],
            ['data' => 'amount', 'title' => __('Amount')],
            ['data' => 'amount_currency', 'title' => __('Amount Currency')],
            ['data' => 'description', 'title' => __('Description')],
            ['data' => 'note', 'title' => __('Note')],
            // ['data' => 'actions', 'title' => __('Actions')],
        ])->responsive(true)
            ->ordering(false)
            ->ajax(route('business.payments', $orderBy)) // Assuming you have a named route for the roles.index endpoint
            ->paging(true)
            ->dom('frtilp')
            ->lengthMenu([[25, 50, 100, -1], [25, 50, 100, "All"]]);

        $methodsJson = $roles->get()->toJson();
        return view('agent.business.payments_new', compact('dataTableHtml', 'orderByFilter', 'methodsJson', 'balance'));
    }
}
