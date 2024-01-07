<?php

namespace App\Http\Controllers\Admin;

use App\Events\ExchangeChatEvent;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\ExchangeAds;
use App\Models\ExchangeBusinessMethod;
use App\Models\ExchangeChat;
use App\Models\ExchangePaymentMethod;
use App\Models\ExchangeTransaction;
use App\Models\Location;
use App\Models\Region;
use App\Models\Towns;
use App\Utils\Enums\ExchangePaymentMethodTypeEnum;
use App\Utils\Enums\ExchangeStatusEnum;
use App\Utils\Enums\ExchangeTransactionStatusEnum;
use App\Utils\Enums\UserTypeEnum;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AdminExchangeController
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

            $ads = ExchangeAds::with('exchange_payment_methods')
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
                ->addColumn('limit', function(ExchangeAds $ad) {
                    return view('agent.exchange.ads_datatable_components._limit', compact( 'ad'));
                })
                ->addColumn('payment', function(ExchangeAds $ad) {
                    $traderSellMethods = $ad->exchange_payment_methods->where('type',\App\Utils\Enums\ExchangePaymentMethodTypeEnum::OWNER_BUY->value)->where('status',1);
                    $lastTraderSell = $traderSellMethods->last();
                    $traderBuyMethods = $ad->exchange_payment_methods->where('type',\App\Utils\Enums\ExchangePaymentMethodTypeEnum::OWNER_SELL->value)->where('status',1);
                    $lastTraderBuy = $traderBuyMethods->last();
                    return view('agent.exchange.ads_datatable_components._payment', compact( 'ad','traderSellMethods','traderBuyMethods','lastTraderSell', 'lastTraderBuy'));
                })
                ->addColumn('trade', function(ExchangeAds $ad) {
                    return '<a href="'.route('admin.exchange.posts.edit', $ad->id).'" class="btn btn-secondary btn-sm">'.__("View Ad").'</a>';
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
            ['data' => 'limit' , 'title' => __('Limit in').' '.strtoupper(session('currency'))],
            ['data' => 'payment', 'title' => __('Payment')],
            ['data' => 'status', 'title' => __('Status')],
            ['data' => 'trade', 'title' => __('general.exchange.trade')],
        ])->responsive(true)
            ->ordering(false)
            ->ajax(route('admin.exchange.ads',$orderBy))
            ->paging(true)
            ->dom('frtilp')
            ->lengthMenu([[25, 50, 100, -1], [25, 50, 100, "All"]]);

        $regions = Region::where('country_code',session('country_code'))->get();

        return view('admin.exchange.ads', compact('dataTableHtml','stats','orderByFilter','regions'));
    }

    public function postsEdit(Request $request, $id)
    {
        $exchangeAd = ExchangeAds::with('exchange_payment_methods')->where('id',$id)->first();
        if(empty($exchangeAd)){
            return redirect()->back()->withErrors(['Invalid Exchange Ad']);
        }

        $businessCode = $exchangeAd->business_code;
        $branches = Location::where('business_code',$businessCode)->get();
        $regions = Region::where('country_code',session('country_code'))->get();
        $businessExchangeMethods = ExchangeBusinessMethod::where('business_code',$businessCode)->get();
        $towns = null;
        $areas = null;

        if($exchangeAd->region_code != null){
            $towns = Towns::where('region_code',$exchangeAd->region_code)->get();
        }

        if($exchangeAd->town_code != null){
            $areas = Area::where('town_code',$exchangeAd->town_code)->get();
        }

        $buyMethods = $exchangeAd->exchange_payment_methods()->where('type', ExchangePaymentMethodTypeEnum::OWNER_BUY->value)->get(['method_name']);
        $sellMethods = $exchangeAd->exchange_payment_methods()->where('type', ExchangePaymentMethodTypeEnum::OWNER_SELL->value)->get(['method_name']);

        return view('admin.exchange.posts_edit', compact('branches','regions','businessExchangeMethods','exchangeAd','towns', 'areas','buyMethods','sellMethods'));
    }

    public function postsEditSubmit(Request $request)
    {
        $request->validate([
            'exchange_id' => 'required|exists:exchange_ads,id',
            'ad_status' => 'required|in:'.implode(',',ExchangeStatusEnum::toArray()),
            'ad_branch' => 'required|exists:locations,code',
            'availability_desc' => 'required|string',
            'ad_region' => 'sometimes|string',
            'ad_town' => 'sometimes|string',
            'ad_area' => 'sometimes|string',
            'ad_buy' => 'required|array',
            'ad_sell' => 'required|array',
            'amount_min' => 'required|numeric|min:1000|max:1000000000',
            'amount_max' => 'required|numeric|min:1000|max:1000000000',
            'description' => 'required|string|max:200',
            'terms' => 'required|string|max:1000',
            'open_note' => 'required|string|max:1000',
        ]);

        $exchangeAd = ExchangeAds::where('id',$request->get('exchange_id'))->first();

        $exchangeAd->location_code = $request->get('ad_branch');
        $exchangeAd->min_amount = $request->get('amount_min');
        $exchangeAd->max_amount = $request->get('amount_max');
        $exchangeAd->description = $request->get('description');
        $exchangeAd->availability_desc = $request->get('availability_desc');
        $exchangeAd->terms = $request->get('terms');
        $exchangeAd->open_note = $request->get('open_note');
        $exchangeAd->status = $request->get('ad_status');

        $region = $request->get('ad_region');
        if($region != 'all'){
            $regionModel = Region::where('code',$region)->get();
            if($regionModel->isNotEmpty()){
                $exchangeAd->region_code = $regionModel->first()->code;
            }
        }

        $town = $request->get('ad_town');
        if($town != 'all'){
            $townModel = Towns::where('code',$town)->get();
            if($townModel->isNotEmpty()){
                $exchangeAd->town_code = $townModel->first()->code;
            }
        }

        $area = $request->get('ad_area');
        if($area != 'all'){
            $areaModel = Area::where('code',$area)->get();
            if($areaModel->isNotEmpty()){
                $exchangeAd->area_code = $areaModel->first()->code;
            }
        }
        $exchangeAd->save();


        $methodsToDelete = ExchangePaymentMethod::where('exchange_ads_code',$exchangeAd->code)->get();
        foreach ($methodsToDelete as $method) {
            $method->delete();
        }

        $buyMethodIds = $request->get('ad_buy');
        $sellMethodIds = $request->get('ad_sell');

        foreach ($buyMethodIds as $buyMethodId) {
            $businessMethod = ExchangeBusinessMethod::where('id',$buyMethodId)->first();
            if($businessMethod != null){
                ExchangePaymentMethod::create([
                    'exchange_ads_code' => $exchangeAd->code,
                    'type' => ExchangePaymentMethodTypeEnum::OWNER_BUY->value,
                    'method_name' => $businessMethod->method_name,
                    'account_number' => $businessMethod->account_number,
                    'account_name' => $businessMethod->account_name,
                ]);
            }
        }

        foreach ($sellMethodIds as $sellMethodId) {
            $businessMethod = ExchangeBusinessMethod::where('id',$sellMethodId)->first();
            if($businessMethod != null){
                ExchangePaymentMethod::create([
                    'exchange_ads_code' => $exchangeAd->code,
                    'type' => ExchangePaymentMethodTypeEnum::OWNER_SELL->value,
                    'method_name' => $businessMethod->method_name,
                    'account_number' => $businessMethod->account_number,
                    'account_name' => $businessMethod->account_name,
                ]);
            }
        }

        return redirect()->route('admin.exchange.ads')->with(['message'=>'Exchange Ad Edited Successfully']);
    }

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

        if(env('APP_ENV') != 'testing'){
            event(new ExchangeChatEvent($chatId,$request->get('message'),$user->name(),$user->business->business_name,now()->toDateTimeString('minute'),$user->id));
        }

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
