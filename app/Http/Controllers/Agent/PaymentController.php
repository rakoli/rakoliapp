<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessAccountTransaction;
use App\Models\BusinessWithdrawMethod;
use App\Models\Location;
use App\Models\Transaction;
use App\Models\WithdrawRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PaymentController extends Controller
{
    public function finance(Request $request)
    {
        $user = \auth()->user();
        $dataTable = new DataTables();
        $builder = $dataTable->getHtmlBuilder();
        $dataTable2 = new DataTables();
        $builder2 = $dataTable2->getHtmlBuilder();

        $withdrawRequests = WithdrawRequest::where('business_code', $user->business_code)->orderBy('id', 'desc');
        $balance = $user->business->balance;
        $withdrawMethod = BusinessWithdrawMethod::where('business_code', $user->business_code)->first();
        $accountTransactions = BusinessAccountTransaction::where('business_code', $user->business_code)->orderBy('id', 'desc');

        if (request()->ajax() && $request->get('table') == 'withdraw_requests') {
            return \Yajra\DataTables\Facades\DataTables::eloquent($withdrawRequests)
                // ->addColumn('actions', function(Transaction $role) {
                //     $content = '<button class="btn btn-secondary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#edit_method_modal" onclick="editClicked('.$role->id.')">'.__("Edit").'</button>';
                //     $content .= '<button class="btn btn-secondary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#delete_method_modal" onclick="deleteClicked('.$role->id.')">'.__("Delete").'</button>';
                //     return $content;
                // })
                // ->rawColumns(['actions'])
                ->addIndexColumn()
                ->addColumn('amount_display',function($row){
                        return number_format($row->amount,2) . ' '.strtoupper($row->amount_currency);
                    })
                ->editColumn('id', function ($row) {
                    return idNumberDisplay($row->id);
                })
                ->editColumn('created_at', function($row) {
                    return Carbon::create($row->created_at)->toDateTimeString('minute');
                })
                ->toJson();
        }

        if (request()->ajax() && $request->get('table') == 'account_transactions') {
            return \Yajra\DataTables\Facades\DataTables::eloquent($accountTransactions)
                // ->addColumn('actions', function(Transaction $role) {
                //     $content = '<button class="btn btn-secondary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#edit_method_modal" onclick="editClicked('.$role->id.')">'.__("Edit").'</button>';
                //     $content .= '<button class="btn btn-secondary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#delete_method_modal" onclick="deleteClicked('.$role->id.')">'.__("Delete").'</button>';
                //     return $content;
                // })
                // ->rawColumns(['actions'])
                ->addIndexColumn()
                ->addColumn('amount_display',function($row){
                    return number_format($row->amount,2) . ' '.strtoupper($row->amount_currency);
                })
                ->editColumn('id', function ($row) {
                    return idNumberDisplay($row->id);
                })
                ->editColumn('created_at', function($row) {
                    return Carbon::create($row->created_at)->toDateTimeString('minute');
                })
                ->toJson();
        }

        // DataTable
        $dataTableHtml = $builder->columns([
            ['data' => 'id', 'title' => __('ID')],
            ['data' => 'method_ac_number', 'title' => __('Method AC Number')],
            ['data' => 'amount_display', 'title' => __('Amount')],
            ['data' => 'status', 'title' => __('Status')],
            ['data' => 'completion_note', 'title' => __('Completion Note')],
            [
                'data' => 'created_at',
                'title' => __('Created At'),
            ],
            // ['data' => 'actions', 'title' => __('Actions')],
        ])->responsive(true)
            ->ordering(false)
            ->ajax(route('business.finance',['table'=>'withdraw_requests']))
            ->paging(true)
            ->dom('rtil')
            ->lengthMenu([[5, 10, 20, -1], [5, 10, 20, "All"]])->setTableId('withdraw_requests');

        $transactionsDataTableHtml = $builder2->columns([
            ['data' => 'id', 'title' => __('ID')],
            ['data' => 'type', 'title' => __('Type')],
            ['data' => 'amount_display', 'title' => __('Amount')],
            ['data' => 'description', 'title' => __('Description')],
            [
                'data' => 'created_at',
                'title' => __('Created At'),
            ],
            // ['data' => 'actions', 'title' => __('Actions')],
        ])->responsive(true)
            ->ordering(false)
            ->ajax(route('business.finance',['table'=>'account_transactions']))
            ->paging(true)
            ->dom('rtil')
            ->lengthMenu([[5, 10, 20, -1], [5, 10, 20, "All"]])->setTableId('account_transactions');

        return view('agent.business.finance', compact('dataTableHtml', 'transactionsDataTableHtml', 'balance', 'withdrawMethod'));
    }

    public function withdrawmethodUpdate(Request $request)
    {
        $request->validate([
            'method_name' => 'required|string',
            'method_ac_name' => 'required|string',
            'method_ac_number' => 'required|string'
        ]);

        $user = $request->user();

        $currency = session('currency');
        if ($currency == null) {
            $currency = $user->business->country->currency;
        }

        BusinessWithdrawMethod::updateOrCreate(
            [
                'business_code' => $request->user()->business_code,
            ],
            [
                'amount_currency' => $currency,
                'method_name' => $request->method_name,
                'method_ac_name' => $request->method_ac_name,
                'method_ac_number' => $request->method_ac_number,
            ]
        );

        return redirect()->route('business.finance')->with(['message' => __('Withdraw Method') . ' ' . __('Updated Successfully')]);
    }

    public function financeWithdraw(Request $request)
    {
        $user = $request->user();
        $balance = $user->business->balance;

        $request->validate([
            'amount' => 'required|numeric|max:'.$balance,
            'description' => 'required|string',
        ]);

        $get_withdraw_method = BusinessWithdrawMethod::where('business_code', $user->business_code)->first();

        if (!$get_withdraw_method) {
            return redirect()->route('business.finance')->withErrors([__('Please add withdrawal method first')]);
        }

        $currency = session('currency');
        if ($currency == null) {
            $currency = $user->business->country->currency;
        }
        if ($request->description != null) {
            $description = $request->description;
        } else {
            $description = '';
        }

        $withdraw = new WithdrawRequest();
        $withdraw->business_code = $request->user()->business_code;
        $withdraw->method_name = $get_withdraw_method->method_name;
        $withdraw->method_ac_name = $get_withdraw_method->method_ac_name;
        $withdraw->method_ac_number = $get_withdraw_method->method_ac_number;
        $withdraw->amount = $request->amount;
        $withdraw->amount_currency = $currency;
        $withdraw->description = $description;
        $withdraw->save();

        return redirect()->route('business.finance')->with(['message' => __('Withdraw Request') . ' ' . __('Added Successfully')]);
    }

    public function checkMethod(Request $request)
    {
        $get_withdraw_method = BusinessWithdrawMethod::where('business_code', $request->user()->business_code)->first();
        if (!$get_withdraw_method) {
            return response()->json(['message' => __('Please add withdrawal method')]);
        } else {
            return response()->json(['message' => 'Withdrawal method exists']);
        }
    }
}
