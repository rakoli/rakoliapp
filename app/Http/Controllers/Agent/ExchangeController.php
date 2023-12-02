<?php

namespace App\Http\Controllers\Agent;

use App\Events\ExchangeChatEvent;
use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\ExchangeAds;
use App\Models\ExchangeChat;
use App\Models\ExchangePaymentMethod;
use App\Models\ExchangeStat;
use App\Models\ExchangeTransaction;
use App\Models\SystemIncome;
use App\Models\User;
use App\Utils\Enums\ExchangeStatusEnum;
use App\Utils\Enums\ExchangeTransactionStatusEnum;
use App\Utils\Enums\ExchangeTransactionTypeEnum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class ExchangeController extends Controller
{
    public function ads(Request $request)
    {
        $stats = null;
        $dataTable = new DataTables();
        $builder = $dataTable->getHtmlBuilder();
        $orderBy = null;
        $orderByFilter = null;
        if($request->get('order_by')){
            $orderBy = ['order_by'=>$request->get('order_by')];
            $orderByFilter = $request->get('order_by');
        }

        if (request()->ajax()) {

            $ads = ExchangeAds::where('status', ExchangeStatusEnum::ACTIVE->value)
                ->with('exchange_payment_methods')
                ->with('business')
                ->with('business_stats');

            if($request->get('order_by') == 'last_seen'){
                $ads->withAggregate('business','last_seen')
                    ->orderByDesc('business_last_seen');
            }

            if($request->get('order_by') == 'trades'){
                $ads->withAggregate('business_stats','no_of_trades_completed')
                    ->orderByDesc('business_stats_no_of_trades_completed');
            }

            if($request->get('order_by') == 'completion'){
                $ads->withAggregate('business_stats','completion')
                    ->orderByDesc('business_stats_completion');
            }

            if($request->get('order_by') == 'feedback' || $request->get('order_by') == null){
                $ads->withAggregate('business_stats','feedback')
                    ->orderByDesc('business_stats_feedback');
            }

            if($request->get('order_by') == 'recent'){
                $ads->latest();
            }

            if($request->get('order_by') == 'min_amount_asc'){
                $ads->orderBy('min_amount','asc');
            }

            if($request->get('order_by') == 'min_amount_desc'){
                $ads->orderBy('min_amount','desc');
            }

            if($request->get('order_by') == 'max_amount_asc'){
                $ads->orderBy('max_amount','asc');
            }

            if($request->get('order_by') == 'max_amount_desc'){
                $ads->orderBy('max_amount','desc');
            }

            return \Yajra\DataTables\Facades\DataTables::eloquent($ads)
                ->addColumn('business_details', function(ExchangeAds $ad) {
                    return view('agent.exchange.ads_datatable_components._business_details', compact( 'ad'));
                })
                ->addColumn('terms', function(ExchangeAds $ad) {
                    return view('agent.exchange.ads_datatable_components._terms', compact( 'ad'));
                })
                ->addColumn('limit', function(ExchangeAds $ad) {
                    return view('agent.exchange.ads_datatable_components._limit', compact( 'ad'));
                })
                ->addColumn('payment', function(ExchangeAds $ad) {
                    $buyMethods = $ad->exchange_payment_methods->where('type',\App\Utils\Enums\ExchangePaymentMethodTypeEnum::OWNER_SEND->value)->where('status',1);
                    $lastBuy = $buyMethods->last();
                    $sellMethods = $ad->exchange_payment_methods->where('type',\App\Utils\Enums\ExchangePaymentMethodTypeEnum::OWNER_RECEIVE->value)->where('status',1);
                    $lastSell = $sellMethods->last();
                    return view('agent.exchange.ads_datatable_components._payment', compact( 'ad','buyMethods','sellMethods','lastBuy', 'lastSell'));
                })
                ->addColumn('trade', function(ExchangeAds $ad) {
                    return '<a href="'.route('exchange.ads.view',$ad->id).'" class="btn btn-light btn-sm">'.__("View Ad").'</a>';
                })
                ->rawColumns(['business_details','terms','limit','payment','trade'])
                ->addIndexColumn()
                ->editColumn('id',function($exchange) {
                    return idNumberDisplay($exchange->id);
                })
                ->toJson();
        }

        //Datatable
        $dataTableHtml = $builder->columns([
            ['data' => 'id', 'title' => __('id')],
            ['data' => 'business_details', 'title' => __('Business')],
            ['data' => 'terms', 'title' => __('Terms')],
            ['data' => 'limit' , 'title' => __('Limit in').' '.strtoupper(session('currency'))],
            ['data' => 'payment', 'title' => __('Payment')],
            ['data' => 'trade', 'title' => __('general.exchange.trade')],
        ])->responsive(true)
            ->ordering(false)
            ->ajax(route('exchange.ads',$orderBy))
            ->paging(true)
            ->dom('frtilp')
            ->lengthMenu([[25, 50, 100, -1], [25, 50, 100, "All"]]);

        return view('agent.exchange.ads', compact('dataTableHtml','stats','orderByFilter'));
    }

    public function adsView(Request $request, $id)
    {
        $exchangeAd = ExchangeAds::where('id',$id)->with('exchange_payment_methods')->first();
        if(empty($exchangeAd)){
            return redirect()->back()->withErrors(['Invalid Exchange Ad']);
        }
        $buyMethods = $exchangeAd->exchange_payment_methods()
            ->where('type',\App\Utils\Enums\ExchangePaymentMethodTypeEnum::OWNER_SEND->value)
            ->where('status', 1)
            ->get(['id','method_name','type']);
        $sellMethods = $exchangeAd->exchange_payment_methods()
            ->where('type',\App\Utils\Enums\ExchangePaymentMethodTypeEnum::OWNER_RECEIVE->value)
            ->where('status', 1)
            ->get(['id','method_name','type']);

        return view('agent.exchange.ads_view',compact('exchangeAd','buyMethods','sellMethods'));
    }

    public function adsOpenOrder(Request $request)
    {
        $exchangeAd = ExchangeAds::where('id',$request->get('exchange_id'))->first();
        $request->validate([
            'exchange_id' => 'required|exists:exchange_ads,id',
            'action_select' => 'required|in:'.implode(',',ExchangeTransactionTypeEnum::toArray()),
            'action_method_select' => 'required|exists:exchange_payment_methods,id',
            'action_for_select' => 'required|exists:exchange_payment_methods,id',
            'amount' => 'required|numeric|min:'.$exchangeAd->min_amount.'|max:'.$exchangeAd->max_amount,
            'comment' => 'sometimes|string',
        ]);
        $exchangeAdCode = $exchangeAd->code;

        $ams = ExchangePaymentMethod::where('id',$request->get('action_method_select'))->first();
        $trader = ExchangePaymentMethod::where('id',$request->get('action_for_select'))->first();
        $comment = $request->get('comment');

        if($exchangeAd->business->code == $request->user()->business->code){
            return redirect()->back()->withErrors(['Not authorized to trade with you own business']);
        }

        $exchangeTransaction = ExchangeTransaction::create([
            'exchange_ads_code' => $exchangeAdCode,
            'owner_business_code' => $exchangeAd->business->code,
            'trader_business_code' => $request->user()->business->code,
            'trader_action_type' => $request->get('action_select'),
            'trader_action_method_id' => $ams->id,
            'trader_action_method' => $ams->method_name,
            'for_method' => $trader->method_name,
            'amount' => $request->get('amount'),
            'amount_currency' => session('currency'),
            'status' => ExchangeTransactionStatusEnum::OPEN,
            'trader_comments' => $comment,
        ]);

        $adOwner = User::where('business_code',$exchangeAd->business_code)->first();
        $openNote = $exchangeAd->open_note;
        if($openNote != null){
            ExchangeChat::create([
                'exchange_trnx_id' => $exchangeTransaction->id,
                'sender_code' => $adOwner->code,
                'message' => $openNote,
            ]);
        }

        if($comment != null){
            ExchangeChat::create([
                'exchange_trnx_id' => $exchangeTransaction->id,
                'sender_code' => $request->user()->code,
                'message' => $comment,
            ]);
        }

        return [
            'success'           => true,
            'result'            => "successful",
            'resultExplanation' => "Order created successfully",
            'orderid' => $exchangeTransaction->id,
        ];
    }

    public function orders()
    {
        $user = \auth()->user();
        $dataTable = new DataTables();
        $builder = $dataTable->getHtmlBuilder();


        if (request()->ajax()) {

            $exchangeTransactions = ExchangeTransaction::where([
                'trader_business_code' => $user->business_code,
                'status' => ExchangeTransactionStatusEnum::OPEN
            ])->orWhere(function (\Illuminate\Database\Eloquent\Builder $query) {
                $query->where('owner_business_code', auth()->user()->business_code)
                    ->where('status', ExchangeTransactionStatusEnum::OPEN);
            })->with('owner_business')
                ->with('trader_business')
                ->orderBy('id','desc');

            return \Yajra\DataTables\Facades\DataTables::eloquent($exchangeTransactions)
                ->addColumn('trade', function(ExchangeTransaction $trn) {
                    return '<a href="'.route('exchange.orders.view',$trn->id).'" class="btn btn-light btn-sm">'.__("Open").'</a>';
                })
                ->editColumn('trader_action_method', function($trn) {
                    return str_camelcase($trn->trader_action_method);
                })
                ->editColumn('for_method', function($trn) {
                    return str_camelcase($trn->for_method);
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
            ['data' => 'owner_business.business_name', 'title' => "Business"],
            ['data' => 'trader_business.business_name', 'title' => "Trader"],
            ['data' => 'trader_action_type' , 'title' => "Action"],
            ['data' => 'trader_action_method', 'title' => "Action Method"],
            ['data' => 'for_method', 'title' => "For"],
            ['data' => 'amount', 'title' => "Amount"],
            ['data' => 'trade', 'title' => "Trade"],
        ])->responsive(true)
            ->ordering(false)
            ->ajax(route('exchange.orders'))
            ->paging(true)
            ->dom('frtilp')
            ->lengthMenu([[25, 50, 100, -1], [25, 50, 100, "All"]])
            ->setTableHeadClass('fw-semibold fs-6 text-gray-800 border-bottom border-gray-200');

        return view('agent.exchange.orders', compact('dataTableHtml'));
    }

    public function ordersView(Request $request, $id)
    {
        $exchangeTransaction = ExchangeTransaction::with('exchange_chats')->where('id',$id)->first();
        if(empty($exchangeTransaction)){
            return redirect()->back()->withErrors(['Invalid Exchange Ad']);
        }

        $isAllowed = $exchangeTransaction->isUserAllowed($request->user());
        if($isAllowed == false){
            return redirect()->route('exchange.orders')->withErrors(['Not authorized to access transaction']);
        }

        $exchangeAd = ExchangeAds::where('code',$exchangeTransaction->exchange_ads_code)->first();

        $chatMessages = $exchangeTransaction->exchange_chats->sortBy('id');

        return view('agent.exchange.orders_view',compact('exchangeAd','exchangeTransaction','chatMessages'));
    }

    public function ordersReceiveMessage(Request $request)
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

    public function ordersAction(Request $request)
    {
        $request->validate([
            'ex_trans_id' => 'required|exists:exchange_transactions,id',
        ]);





        return [
            'status' => 200,
            'message' => "successful"
        ];
    }

    public function transactions()
    {

        return view('agent.exchange.transactions');
    }


    public function posts()
    {

        return view('agent.exchange.posts');
    }


    public function security()
    {

        return view('agent.exchange.security');
    }
}
