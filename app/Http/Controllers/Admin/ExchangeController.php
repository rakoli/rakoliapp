<?php

namespace App\Http\Controllers\Admin;

use App\Events\ExchangeChatEvent;
use App\Http\Controllers\Controller;
use App\Models\ExchangeAds;
use App\Models\ExchangeChat;
use App\Models\ExchangeTransaction;
use App\Utils\Enums\ExchangeTransactionStatusEnum;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ExchangeController
{

    public function transactions()
    {

        $user = \auth()->user();
        $dataTable = new DataTables();
        $builder = $dataTable->getHtmlBuilder();

        if (request()->ajax()) {

            $exchangeTransactions = ExchangeTransaction::with('owner_business')
                ->with('trader_business')
                ->orderBy('id','desc');

            return \Yajra\DataTables\Facades\DataTables::eloquent($exchangeTransactions)
                ->addColumn('trade', function(ExchangeTransaction $trn) {
                    return '<a href="'.route('admin.exchange.transactions.view',$trn->id).'" class="btn btn-secondary btn-sm">'.__("View").'</a>';
                })
                ->editColumn('trader_action_type', function($trn) {
                    return __($trn->trader_action_type);
                })
                ->editColumn('trader_target_method', function($trn) {
                    return str_camelcase($trn->trader_target_method);
                })
                ->editColumn('trader_action_via_method', function($trn) {
                    return str_camelcase($trn->trader_action_via_method);
                })
                ->editColumn('amount', function($trn) {
                    return number_format($trn->amount,2);
                })
                ->addIndexColumn()
                ->rawColumns(['amount','trade'])
                ->editColumn('id',function($exchange) {
                    return idNumberDisplay($exchange->id);
                })
                ->toJson();
        }

        //Datatable
        $dataTableHtml = $builder->columns([
            ['data' => 'id', 'title' => __('id')],
            ['data' => 'status', 'title' => __("Status")],
            ['data' => 'owner_business.business_name', 'title' => __("Advertiser")],
            ['data' => 'trader_business.business_name', 'title' => __("Applicant")],
            ['data' => 'trader_action_type' , 'title' => __("Action")],
            ['data' => 'trader_target_method', 'title' => __("Target")],
            ['data' => 'trader_action_via_method', 'title' => __("Via")],
            ['data' => 'amount', 'title' => __("Amount")],
            ['data' => 'trade', 'title' => __("Trade")],
        ])->responsive(true)
            ->ordering(false)
            ->ajax(route('admin.exchange.transactions'))
            ->paging(true)
            ->dom('frtilp')
            ->lengthMenu([[25, 50, 100, -1], [25, 50, 100, "All"]]);

        return view('admin.exchange.transactions',compact('dataTableHtml'));
    }

    public function transactionsView(Request $request, $id)
    {
        $exchangeTransaction = ExchangeTransaction::with('exchange_chats')->where('id',$id)->first();
        if(empty($exchangeTransaction)){
            return redirect()->back()->withErrors(['Invalid Exchange Ad']);
        }

        $exchangeAd = ExchangeAds::where('code',$exchangeTransaction->exchange_ads_code)->first();

        $chatMessages = $exchangeTransaction->exchange_chats->sortBy('id');

        return view('admin.exchange.transactions_view',compact('exchangeAd','exchangeTransaction','chatMessages'));
    }

    public function transactionsReceiveMessage(Request $request)
    {
        $request->validate([
            'ex_trans_id' => 'required|exists:exchange_transactions,id',
            'message' => 'required|string|min:1|max:200',
        ]);
        $chatId = $request->get('ex_trans_id');
        $user = $request->user();
        ExchangeChat::create([
            'exchange_trnx_id' => $chatId,
            'sender_code' => $user->code,
            'message' => $request->get('message'),
        ]);

        event(new ExchangeChatEvent($chatId,$request->get('message'),$user->name(),$user->business->business_name,now()->toDateTimeString('minute'),$user->id));

        return [
            'status' => 200,
            'message' => "successful"
        ];
    }

    public function transactionsAction(Request $request)
    {
        $request->validate([
            'ex_trans_id' => 'required|exists:exchange_transactions,id',
            'action' => 'required|in:complete,report,cancel',
            'message' => 'sometimes|string|min:10|max:255',
        ]);
        $exchangeTransactionId = $request->get('ex_trans_id');
        $exchangeTransaction = ExchangeTransaction::where('id',$exchangeTransactionId)->first();
        $action = $request->get('action');
        $user = $request->user();

        if($exchangeTransaction->is_complete){
            return redirect()->back()->withErrors('Trade Already Completed');
        }

        if($action == 'cancel'){

            $exchangeTransaction->is_complete = true;
            $exchangeTransaction->cancelled_at = now();
            $exchangeTransaction->cancelled_by_user_code = $user->code;
            $exchangeTransaction->status = ExchangeTransactionStatusEnum::CANCELLED->value;
            $exchangeTransaction->save();

            return redirect()->back()->with(['message'=>'Trade Successfully Cancelled']);
        }

        if($action == 'complete'){

            $exchangeTransaction->is_complete = true;
            $exchangeTransaction->admin_confirm_at = now();
            $exchangeTransaction->admin_confirm_by_user_code = $user->code;
            $exchangeTransaction->status = ExchangeTransactionStatusEnum::COMPLETED->value;
            $exchangeTransaction->save();

            return redirect()->back()->with('Trade Successfully Cancelled');
        }

        //Todo: Add Trade Update Notification

        return redirect()->back()->withErrors(['Error! Action Error']);
    }


}
