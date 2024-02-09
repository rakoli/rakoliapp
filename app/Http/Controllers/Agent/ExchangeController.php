<?php

namespace App\Http\Controllers\Agent;

use App\Events\ExchangeChatEvent;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Business;
use App\Models\ExchangeAds;
use App\Models\ExchangeBusinessMethod;
use App\Models\ExchangeChat;
use App\Models\ExchangeFeedback;
use App\Models\ExchangePaymentMethod;
use App\Models\ExchangeTransaction;
use App\Models\Location;
use App\Models\Region;
use App\Models\Towns;
use App\Models\User;
use App\Utils\Enums\ExchangePaymentMethodTypeEnum;
use App\Utils\Enums\ExchangeStatusEnum;
use App\Utils\Enums\ExchangeTransactionStatusEnum;
use App\Utils\Enums\ExchangeTransactionTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ExchangeController extends Controller
{
    public function ads(Request $request)
    {
        //Todo: Write unit test for ExchangeAds market Order By Filters
        $stats = null;
        $dataTable = new DataTables();
        $builder = $dataTable->getHtmlBuilder();
        $orderBy = null;
        $orderByFilter = null;
        if ($request->get('order_by')) {
            $orderBy = ['order_by' => $request->get('order_by')];
            $orderByFilter = $request->get('order_by');
        }

        if (request()->ajax()) {

            $ads = ExchangeAds::where('status', ExchangeStatusEnum::ACTIVE->value)
                ->with('exchange_payment_methods')
                ->with('business')
                ->with('business_stats');

            if ($request->get('order_by') == 'last_seen') {
                $ads->withAggregate('business', 'last_seen')
                    ->orderByDesc('business_last_seen');
            }

            if ($request->get('order_by') == 'trades') {
                $ads->withAggregate('business_stats', 'no_of_trades_completed')
                    ->orderByDesc('business_stats_no_of_trades_completed');
            }

            if ($request->get('order_by') == 'completion') {
                $ads->withAggregate('business_stats', 'completion')
                    ->orderByDesc('business_stats_completion');
            }

            if ($request->get('order_by') == 'feedback' || $request->get('order_by') == null) {
                $ads->withAggregate('business_stats', 'feedback')
                    ->orderByDesc('business_stats_feedback');
            }

            if ($request->get('order_by') == 'recent') {
                $ads->latest();
            }

            if ($request->get('order_by') == 'min_amount_asc') {
                $ads->orderBy('min_amount', 'asc');
            }

            if ($request->get('order_by') == 'min_amount_desc') {
                $ads->orderBy('min_amount', 'desc');
            }

            if ($request->get('order_by') == 'max_amount_asc') {
                $ads->orderBy('max_amount', 'asc');
            }

            if ($request->get('order_by') == 'max_amount_desc') {
                $ads->orderBy('max_amount', 'desc');
            }

            return \Yajra\DataTables\Facades\DataTables::eloquent($ads)
                ->addColumn('business_details', function (ExchangeAds $ad) {
                    return view('agent.exchange.ads_datatable_components._business_details', compact('ad'));
                })
                ->addColumn('terms', function (ExchangeAds $ad) {
                    return view('agent.exchange.ads_datatable_components._terms', compact('ad'));
                })
                ->addColumn('limit', function (ExchangeAds $ad) {
                    return view('agent.exchange.ads_datatable_components._limit', compact('ad'));
                })
                ->addColumn('payment', function (ExchangeAds $ad) {
                    $traderSellMethods = $ad->exchange_payment_methods->where('type', \App\Utils\Enums\ExchangePaymentMethodTypeEnum::OWNER_BUY->value)->where('status', 1);
                    $lastTraderSell = $traderSellMethods->last();
                    $traderBuyMethods = $ad->exchange_payment_methods->where('type', \App\Utils\Enums\ExchangePaymentMethodTypeEnum::OWNER_SELL->value)->where('status', 1);
                    $lastTraderBuy = $traderBuyMethods->last();

                    return view('agent.exchange.ads_datatable_components._payment', compact('ad', 'traderSellMethods', 'traderBuyMethods', 'lastTraderSell', 'lastTraderBuy'));
                })
                ->addColumn('trade', function (ExchangeAds $ad) {
                    return '<a href="'.route('exchange.ads.view', $ad->id).'" class="btn btn-secondary btn-sm">'.__('View Ad').'</a>';
                })
                ->rawColumns(['business_details', 'terms', 'limit', 'payment', 'trade'])
                ->addIndexColumn()
                ->editColumn('id', function ($exchange) {
                    return idNumberDisplay($exchange->id);
                })
                ->toJson();
        }

        //Datatable
        $dataTableHtml = $builder->columns([
            ['data' => 'id', 'title' => __('id')],
            ['data' => 'business_details', 'title' => __('Business')],
            ['data' => 'terms', 'title' => __('Terms')],
            ['data' => 'limit', 'title' => __('Limit in').' '.strtoupper(session('currency'))],
            ['data' => 'payment', 'title' => __('Payment')],
            ['data' => 'trade', 'title' => __('general.exchange.trade')],
        ])->responsive(true)
            ->ordering(false)
            ->ajax(route('exchange.ads', $orderBy))
            ->paging(true)
            ->dom('frtilp')
            ->lengthMenu([[25, 50, 100, -1], [25, 50, 100, 'All']]);

        $regions = Region::where('country_code', session('country_code'))->get();

        return view('agent.exchange.ads', compact('dataTableHtml', 'stats', 'orderByFilter', 'regions'));
    }

    public function adsView(Request $request, $id)
    {
        $exchangeAd = ExchangeAds::where('id', $id)->with('exchange_payment_methods')->first();
        if (empty($exchangeAd)) {
            return redirect()->back()->withErrors(['Invalid Exchange Ad']);
        }
        $traderSellMethods = $exchangeAd->exchange_payment_methods()
            ->where('type', \App\Utils\Enums\ExchangePaymentMethodTypeEnum::OWNER_BUY->value)
            ->where('status', 1)
            ->get(['id', 'method_name', 'type']);
        $traderBuyMethods = $exchangeAd->exchange_payment_methods()
            ->where('type', \App\Utils\Enums\ExchangePaymentMethodTypeEnum::OWNER_SELL->value)
            ->where('status', 1)
            ->get(['id', 'method_name', 'type']);

        return view('agent.exchange.ads_view', compact('exchangeAd', 'traderSellMethods', 'traderBuyMethods'));
    }

    public function adsOpenOrder(Request $request)
    {
        $exchangeAd = ExchangeAds::where('id', $request->get('exchange_id'))->first();
        $request->validate([
            'exchange_id' => 'required|exists:exchange_ads,id',
            'action_select' => 'required|in:'.implode(',', ExchangeTransactionTypeEnum::toArray()),
            'action_target_select' => 'required|exists:exchange_payment_methods,id',
            'action_via_select' => 'required|exists:exchange_payment_methods,id',
            'amount' => 'required|numeric|min:'.$exchangeAd->min_amount.'|max:'.$exchangeAd->max_amount,
            'comment' => 'sometimes|string',
        ]);
        $exchangeAdCode = $exchangeAd->code;
        $user = $request->user();

        $targetMethod = ExchangePaymentMethod::where('id', $request->get('action_target_select'))->first();
        $viaMethod = ExchangePaymentMethod::where('id', $request->get('action_via_select'))->first();
        $comment = $request->get('comment');

        if ($exchangeAd->business->code == $request->user()->business->code) {
            return [
                'success' => false,
                'result' => 'failed',
                'resultExplanation' => 'Not authorized to trade with you own business',
            ];
        }

        //        $exTranChecker = ExchangeTransaction::where(['trader_business_code'=>$request->user()->business->code, 'is_complete'=>0])->first();
        //        if($exTranChecker != null){
        //            return [
        //                'success'           => false,
        //                'result'            => "failed",
        //                'resultExplanation' => "There is already a pending transaction",
        //            ];
        //        }

        $currency = session('currency');
        if ($currency == null) {
            $currency = $user->business->country->currency;
        }

        $exchangeTransaction = ExchangeTransaction::create([
            'exchange_ads_code' => $exchangeAdCode,
            'owner_business_code' => $exchangeAd->business->code,
            'trader_business_code' => $request->user()->business->code,
            'trader_action_type' => $request->get('action_select'),
            'trader_target_method' => $targetMethod->method_name,
            'trader_action_via_method_id' => $viaMethod->id,
            'trader_action_via_method' => $viaMethod->method_name,
            'amount' => $request->get('amount'),
            'amount_currency' => $currency,
            'status' => ExchangeTransactionStatusEnum::OPEN,
            'trader_comments' => $comment,
        ]);

        $adOwner = User::where('business_code', $exchangeAd->business_code)->first();
        $openNote = $exchangeAd->open_note;
        if ($openNote != null) {
            ExchangeChat::create([
                'exchange_trnx_id' => $exchangeTransaction->id,
                'sender_code' => $adOwner->code,
                'message' => $openNote,
            ]);
        }

        if ($comment != null) {
            ExchangeChat::create([
                'exchange_trnx_id' => $exchangeTransaction->id,
                'sender_code' => $request->user()->code,
                'message' => $comment,
            ]);
        }

        return [
            'success' => true,
            'result' => 'successful',
            'resultExplanation' => 'Order created successfully',
            'orderid' => $exchangeTransaction->id,
        ];
    }

    public function transactions()
    {
        $user = \auth()->user();
        $dataTable = new DataTables();
        $builder = $dataTable->getHtmlBuilder();

        if (request()->ajax()) {

            $exchangeTransactions = ExchangeTransaction::where([
                'trader_business_code' => $user->business_code,
            ])->orWhere(function (\Illuminate\Database\Eloquent\Builder $query) {
                $query->where('owner_business_code', auth()->user()->business_code);
            })->with('owner_business')
                ->with('trader_business')
                ->orderBy('id', 'desc');

            //            $exchangeTransactions = ExchangeTransaction::where([
            //                'trader_business_code' => $user->business_code,
            //                'status' => ExchangeTransactionStatusEnum::OPEN
            //            ])->orWhere(function (\Illuminate\Database\Eloquent\Builder $query) {
            //                $query->where('owner_business_code', auth()->user()->business_code)
            //                    ->where('status', ExchangeTransactionStatusEnum::OPEN);
            //            })->with('owner_business')
            //                ->with('trader_business')
            //                ->orderBy('id','desc');

            return \Yajra\DataTables\Facades\DataTables::eloquent($exchangeTransactions)
                ->addColumn('trade', function (ExchangeTransaction $trn) {
                    return '<a href="'.route('exchange.transactions.view', $trn->id).'" class="btn btn-secondary btn-sm">'.__('View').'</a>';
                })
                ->editColumn('trader_action_type', function ($trn) {
                    return __($trn->trader_action_type);
                })
                ->editColumn('trader_target_method', function ($trn) {
                    return str_camelcase($trn->trader_target_method);
                })
                ->editColumn('trader_action_via_method', function ($trn) {
                    return str_camelcase($trn->trader_action_via_method);
                })
                ->addColumn('amount_display', function ($row) {
                    return number_format($row->amount, 2).' '.strtoupper($row->amount_currency);
                })
                ->addIndexColumn()
                ->rawColumns(['trade'])
                ->editColumn('id', function ($exchange) {
                    return idNumberDisplay($exchange->id);
                })
                ->toJson();
        }

        //Datatable
        $dataTableHtml = $builder->columns([
            ['data' => 'id', 'title' => __('id')],
            ['data' => 'status', 'title' => __('Status')],
            ['data' => 'owner_business.business_name', 'title' => __('Advertiser')],
            ['data' => 'trader_business.business_name', 'title' => __('Applicant')],
            ['data' => 'trader_action_type', 'title' => __('Action')],
            ['data' => 'trader_target_method', 'title' => __('Target')],
            ['data' => 'trader_action_via_method', 'title' => __('Via')],
            ['data' => 'amount_display', 'title' => __('Amount')],
            ['data' => 'trade', 'title' => __('Trade')],
        ])->responsive(true)
            ->ordering(false)
            ->ajax(route('exchange.transactions'))
            ->paging(true)
            ->dom('frtilp')
            ->lengthMenu([[25, 50, 100, -1], [25, 50, 100, 'All']]);

        return view('agent.exchange.transactions', compact('dataTableHtml'));
    }

    public function transactionsView(Request $request, $id)
    {
        $exchangeTransaction = ExchangeTransaction::with('exchange_chats')->where('id', $id)->first();
        if (empty($exchangeTransaction)) {
            return redirect()->back()->withErrors(['Invalid Exchange Ad']);
        }

        $isAllowed = $exchangeTransaction->isUserAllowed($request->user());
        if ($isAllowed == false) {
            return redirect()->route('exchange.transactions')->withErrors(['Not authorized to access transaction']);
        }

        $exchangeAd = ExchangeAds::where('code', $exchangeTransaction->exchange_ads_code)->first();

        $chatMessages = $exchangeTransaction->exchange_chats->sortBy('id');

        return view('agent.exchange.transactions_view', compact('exchangeAd', 'exchangeTransaction', 'chatMessages'));
    }

    public function transactionsReceiveMessage(Request $request)
    {
        $request->validate([
            'ex_trans_id' => 'required|exists:exchange_transactions,id',
            'message' => 'required|string|min:1|max:200',
        ]);
        $chatId = $request->get('ex_trans_id');
        $user = $request->user();

        $exchangeTransactionId = $request->get('ex_trans_id');
        $exchangeTransaction = ExchangeTransaction::where('id', $exchangeTransactionId)->first();
        $isAllowed = $exchangeTransaction->isUserAllowed($user);
        if ($isAllowed == false) {
            return redirect()->route('exchange.transactions')->withErrors(['Not authorized to access transaction']);
        }

        ExchangeChat::create([
            'exchange_trnx_id' => $chatId,
            'sender_code' => $user->code,
            'message' => $request->get('message'),
        ]);

        if (env('APP_ENV') != 'testing') {
            event(new ExchangeChatEvent($chatId, $request->get('message'), $user->name(), $user->business->business_name, now()->toDateTimeString('minute'), $user->id));
        }

        return [
            'status' => 200,
            'message' => 'successful',
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
        $exchangeTransaction = ExchangeTransaction::where('id', $exchangeTransactionId)->first();
        $action = $request->get('action');
        $user = $request->user();

        $isAllowed = $exchangeTransaction->isUserAllowed($user);
        if ($isAllowed == false) {
            return redirect()->route('exchange.transactions')->withErrors(['Not authorized to access transaction']);
        }

        if ($exchangeTransaction->is_complete) {
            return redirect()->back()->withErrors('Trade Already Completed');
        }

        if ($action == 'cancel') {

            if ($exchangeTransaction->status != ExchangeTransactionStatusEnum::OPEN->value) {
                return redirect()->back()->withErrors(['Error! Trade already in progress']);
            }

            $exchangeTransaction->is_complete = true;
            $exchangeTransaction->cancelled_at = now();
            $exchangeTransaction->cancelled_by_user_code = $user->code;
            $exchangeTransaction->status = ExchangeTransactionStatusEnum::CANCELLED->value;
            $exchangeTransaction->save();

            return redirect()->back()->with(['message' => 'Trade Successfully Cancelled']);
        }

        if ($action == 'complete') {

            if ($exchangeTransaction->isTrader($user)) {
                $exchangeTransaction->status = ExchangeTransactionStatusEnum::PENDING_RELEASE->value;
                $exchangeTransaction->trader_confirm_at = now();
                $exchangeTransaction->trader_confirm_by_user_code = $user->code;
                $exchangeTransaction->save();
            }

            if ($exchangeTransaction->isOwner($user)) {
                $exchangeTransaction->status = ExchangeTransactionStatusEnum::PENDING_RELEASE->value;
                $exchangeTransaction->owner_confirm_at = now();
                $exchangeTransaction->owner_confirm_by_user_code = $user->code;
                $exchangeTransaction->save();
            }

            if ($exchangeTransaction->trader_confirm_at != null && $exchangeTransaction->owner_confirm_at != null) {
                $exchangeTransaction->is_complete = true;
                $exchangeTransaction->status = ExchangeTransactionStatusEnum::COMPLETED->value;
                $exchangeTransaction->save();
            }

            return redirect()->back()->with('Trade Successfully Cancelled');
        }

        //Todo: Add Trade Update Notification

        return redirect()->back()->withErrors(['Error! Action Error']);
    }

    public function transactionsFeedbackAction(Request $request)
    {
        $request->validate([
            'ex_trans_id' => 'required|exists:exchange_transactions,id',
            'feedback' => 'required|in:1,0',
            'comments' => 'sometimes|nullable|string|min:2|max:255',
        ]);
        $user = \auth()->user();

        $exchangeId = $request->get('ex_trans_id');
        $exchangeTransaction = ExchangeTransaction::where('id', $exchangeId)->first();
        $isOwner = $exchangeTransaction->isOwner($user);
        $isTrader = $exchangeTransaction->isTrader($user);

        $isAllowed = $exchangeTransaction->isUserAllowed($user);
        if ($isAllowed == false) {
            return redirect()->route('exchange.transactions')->withErrors(['Not authorized to access transaction']);
        }

        if ($isOwner && $exchangeTransaction->owner_submitted_feedback == true) {
            return redirect()->back()->withErrors(['Error! Feedback already submitted']);
        }

        if ($isTrader && $exchangeTransaction->trader_submitted_feedback == true) {
            return redirect()->back()->withErrors(['Error! Feedback already submitted']);
        }

        $reviewerBusinessCode = $user->business_code;
        $reviewedBusinessCode = null;
        if ($exchangeTransaction->owner_business_code == $reviewerBusinessCode) {
            $reviewedBusinessCode = $exchangeTransaction->trader_business_code;
        }
        if ($exchangeTransaction->trader_business_code == $reviewerBusinessCode) {
            $reviewedBusinessCode = $exchangeTransaction->owner_business_code;
        }

        ExchangeFeedback::create([
            'exchange_trnx_id' => $exchangeId,
            'reviewed_business_code' => $reviewedBusinessCode,
            'review' => $request->get('feedback'),
            'review_comment' => $request->get('comments'),
            'reviewer_user_code' => $user->code,
        ]);

        if ($isOwner) {
            $exchangeTransaction->owner_submitted_feedback = true;
        }
        if ($isTrader) {
            $exchangeTransaction->trader_submitted_feedback = true;
        }
        $exchangeTransaction->save();

        return redirect()->back()->with(['message' => 'Exchange Feedback Submitted']);
    }

    public function posts(Request $request)
    {
        $user = \auth()->user();
        $dataTable = new DataTables();
        $builder = $dataTable->getHtmlBuilder();

        if (request()->ajax()) {
            $exchangePosts = ExchangeAds::where('business_code', $user->business_code)->orderBy('id', 'desc')->with('exchange_payment_methods');

            return \Yajra\DataTables\Facades\DataTables::eloquent($exchangePosts)
                ->addColumn('action', function (ExchangeAds $trn) {
                    $content = '<a class="btn btn-secondary btn-sm me-2" href="'.route('exchange.posts.edit', $trn->id).'">'.__('Edit').'</a>';
                    if ($trn->status != ExchangeStatusEnum::DELETED->value) {
                        $content .= '<button class="btn btn-secondary btn-sm me-2" onclick="deleteClicked('.$trn->id.')">'.__('Delete').'</button>';
                    }

                    return $content;
                })
                ->addColumn('range', function (ExchangeAds $trn) {
                    $min = number_format($trn->min_amount);
                    $max = number_format($trn->max_amount);

                    return "$min to $max";
                })
                ->addColumn('payment', function (ExchangeAds $ad) {
                    $ownerSellMethods = $ad->exchange_payment_methods->where('type', \App\Utils\Enums\ExchangePaymentMethodTypeEnum::OWNER_SELL->value)->where('status', 1);
                    $ownerBuyMethods = $ad->exchange_payment_methods->where('type', \App\Utils\Enums\ExchangePaymentMethodTypeEnum::OWNER_BUY->value)->where('status', 1);

                    $traderSellMethods = $ownerSellMethods; //To match view display, should be opposite since is owner load
                    $lastTraderSell = $traderSellMethods->last();

                    $traderBuyMethods = $ownerBuyMethods; //To match view display, should be opposite since is owner load
                    $lastTraderBuy = $traderBuyMethods->last();

                    return view('agent.exchange.ads_datatable_components._payment', compact('ad', 'traderSellMethods', 'traderBuyMethods', 'lastTraderSell', 'lastTraderBuy'));
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->editColumn('id', function ($method) {
                    return idNumberDisplay($method->id);
                })
                ->editColumn('location', function ($method) {
                    return $method->location->name;
                })
                ->toJson();
        }

        //Datatable
        $dataTableHtml = $builder->columns([
            ['data' => 'id', 'title' => __('id')],
            ['data' => 'location', 'title' => __('Branch')],
            ['data' => 'range', 'title' => __('Range').' ('.session('currency').')'],
            ['data' => 'payment', 'title' => __('Payment')],
            ['data' => 'status', 'title' => __('Status')],
            ['data' => 'action', 'title' => __('Action')],
        ])->responsive(true)
            ->ordering(false)
            ->ajax(route('exchange.posts'))
            ->paging(true)
            ->dom('frtilp')
            ->lengthMenu([[25, 50, 100, -1], [25, 50, 100, 'All']]);

        return view('agent.exchange.posts', compact('dataTableHtml'));
    }

    public function postsCreate()
    {
        $businessCode = \auth()->user()->business_code;
        $branches = Location::where('business_code', $businessCode)->get();
        $regions = Region::where('country_code', session('country_code'))->get();
        $businessExchangeMethods = ExchangeBusinessMethod::where('business_code', $businessCode)->get();

        return view('agent.exchange.posts_create', compact('branches', 'regions', 'businessExchangeMethods'));
    }

    public function postsEdit(Request $request, $id)
    {
        $exchangeAd = ExchangeAds::with('exchange_payment_methods')->where('id', $id)->first();
        if (empty($exchangeAd)) {
            return redirect()->back()->withErrors(['Invalid Exchange Ad']);
        }

        $isAllowed = $exchangeAd->isUserAllowed($request->user());
        if ($isAllowed == false) {
            return redirect()->route('exchange.posts')->withErrors(['Not authorized to access transaction']);
        }

        $businessCode = \auth()->user()->business_code;
        $branches = Location::where('business_code', $businessCode)->get();
        $regions = Region::where('country_code', session('country_code'))->get();
        $businessExchangeMethods = ExchangeBusinessMethod::where('business_code', $businessCode)->get();
        $towns = null;
        $areas = null;

        if ($exchangeAd->region_code != null) {
            $towns = Towns::where('region_code', $exchangeAd->region_code)->get();
        }

        if ($exchangeAd->town_code != null) {
            $areas = Area::where('town_code', $exchangeAd->town_code)->get();
        }

        $buyMethods = $exchangeAd->exchange_payment_methods()->where('type', ExchangePaymentMethodTypeEnum::OWNER_BUY->value)->get(['method_name']);
        $sellMethods = $exchangeAd->exchange_payment_methods()->where('type', ExchangePaymentMethodTypeEnum::OWNER_SELL->value)->get(['method_name']);

        return view('agent.exchange.posts_edit', compact('branches', 'regions', 'businessExchangeMethods', 'exchangeAd', 'towns', 'areas', 'buyMethods', 'sellMethods'));
    }

    public function postsDelete(Request $request, $id)
    {
        $exchangeAd = ExchangeAds::with('exchange_payment_methods')->where('id', $id)->first();
        if (empty($exchangeAd)) {
            return redirect()->back()->withErrors(['Invalid Exchange Ad']);
        }

        $isAllowed = $exchangeAd->isUserAllowed($request->user());
        if ($isAllowed == false) {
            return redirect()->route('exchange.posts')->withErrors(['Not authorized to access transaction']);
        }

        $exchangeAd->status = ExchangeStatusEnum::DELETED->value;
        $exchangeAd->save();

        return redirect()->route('exchange.posts')->with(['message' => 'Exchange Ad Deleted Successfully']);
    }

    public function postsCreateSubmit(Request $request)
    {
        $request->validate([
            'ad_branch' => 'required|exists:locations,code',
            'availability_desc' => 'required|string',
            'ad_region' => 'sometimes',
            'ad_town' => 'sometimes',
            'ad_area' => 'sometimes',
            'ad_buy' => 'required|array',
            'ad_sell' => 'required|array',
            'amount_min' => 'required|numeric|min:1000|max:1000000000',
            'amount_max' => 'required|numeric|min:1000|max:1000000000',
            'description' => 'required|string|max:200',
            'terms' => 'required|string|max:500',
            'open_note' => 'required|string|max:500',
        ]);
        $user = $request->user();
        $buyMethodIds = $request->get('ad_buy');
        $sellMethodIds = $request->get('ad_sell');

        $currency = session('currency');
        if ($currency == null) {
            $currency = $user->business->country->currency;
        }

        $exchangeAdData = [
            'country_code' => $user->country_code,
            'business_code' => $user->business_code,
            'location_code' => $request->ad_branch,
            'code' => generateCode(Str::random(10), 'TZ'),
            'min_amount' => $request->amount_min,
            'max_amount' => $request->amount_max,
            'currency' => $currency,
            'status' => ExchangeStatusEnum::PENDING->value,
            'description' => $request->description,
            'availability_desc' => $request->availability_desc,
            'terms' => $request->terms,
            'open_note' => $request->open_note,
        ];

        $region = $request->get('ad_region');
        if ($region != 'all') {
            $regionModel = Region::where('code', $region)->get();
            if ($regionModel->isNotEmpty()) {
                $exchangeAdData['region_code'] = $regionModel->first()->code;
            }
        }

        $town = $request->get('ad_town');
        if ($town != 'all') {
            $townModel = Towns::where('code', $town)->get();
            if ($townModel->isNotEmpty()) {
                $exchangeAdData['town_code'] = $townModel->first()->code;
            }
        }

        $area = $request->get('ad_area');
        if ($area != 'all') {
            $areaModel = Area::where('code', $area)->get();
            if ($areaModel->isNotEmpty()) {
                $exchangeAdData['area_code'] = $areaModel->first()->code;
            }
        }

        $exchangeAd = ExchangeAds::create($exchangeAdData);

        foreach ($buyMethodIds as $buyMethodId) {
            $businessMethod = ExchangeBusinessMethod::where('id', $buyMethodId)->first();
            ExchangePaymentMethod::create([
                'exchange_ads_code' => $exchangeAd->code,
                'type' => ExchangePaymentMethodTypeEnum::OWNER_BUY->value,
                'method_name' => $businessMethod->method_name,
                'account_number' => $businessMethod->account_number,
                'account_name' => $businessMethod->account_name,
            ]);
        }

        foreach ($sellMethodIds as $sellMethodId) {
            $businessMethod = ExchangeBusinessMethod::where('id', $sellMethodId)->first();
            ExchangePaymentMethod::create([
                'exchange_ads_code' => $exchangeAd->code,
                'type' => ExchangePaymentMethodTypeEnum::OWNER_SELL->value,
                'method_name' => $businessMethod->method_name,
                'account_number' => $businessMethod->account_number,
                'account_name' => $businessMethod->account_name,
            ]);
        }

        return redirect()->route('exchange.posts')->with(['message' => 'Exchange Ad Post Submitted']);
    }

    public function postsEditSubmit(Request $request)
    {
        $request->validate([
            'exchange_id' => 'required|exists:exchange_ads,id',
            'ad_status' => 'required|in:'.implode(',', ExchangeStatusEnum::toArray()),
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

        $exchangeAd = ExchangeAds::where('id', $request->get('exchange_id'))->first();

        $isAllowed = $exchangeAd->isUserAllowed($request->user());
        if ($isAllowed == false) {
            return redirect()->route('exchange.posts')->withErrors(['Not authorized to access transaction']);
        }

        $exchangeAd->location_code = $request->get('ad_branch');
        $exchangeAd->min_amount = $request->get('amount_min');
        $exchangeAd->max_amount = $request->get('amount_max');
        $exchangeAd->description = $request->get('description');
        $exchangeAd->availability_desc = $request->get('availability_desc');
        $exchangeAd->terms = $request->get('terms');
        $exchangeAd->open_note = $request->get('open_note');

        if (in_array($request->get('ad_status'), ExchangeStatusEnum::userViewable())) {
            $exchangeAd->status = $request->get('ad_status');
        }

        $region = $request->get('ad_region');
        if ($region != 'all') {
            $regionModel = Region::where('code', $region)->get();
            if ($regionModel->isNotEmpty()) {
                $exchangeAd->region_code = $regionModel->first()->code;
            }
        }

        $town = $request->get('ad_town');
        if ($town != 'all') {
            $townModel = Towns::where('code', $town)->get();
            if ($townModel->isNotEmpty()) {
                $exchangeAd->town_code = $townModel->first()->code;
            }
        }

        $area = $request->get('ad_area');
        if ($area != 'all') {
            $areaModel = Area::where('code', $area)->get();
            if ($areaModel->isNotEmpty()) {
                $exchangeAd->area_code = $areaModel->first()->code;
            }
        }
        $exchangeAd->save();

        $methodsToDelete = ExchangePaymentMethod::where('exchange_ads_code', $exchangeAd->code)->get();
        foreach ($methodsToDelete as $method) {
            $method->delete();
        }

        $buyMethodIds = $request->get('ad_buy');
        $sellMethodIds = $request->get('ad_sell');

        foreach ($buyMethodIds as $buyMethodId) {
            $businessMethod = ExchangeBusinessMethod::where('id', $buyMethodId)->first();
            if ($businessMethod != null) {
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
            $businessMethod = ExchangeBusinessMethod::where('id', $sellMethodId)->first();
            if ($businessMethod != null) {
                ExchangePaymentMethod::create([
                    'exchange_ads_code' => $exchangeAd->code,
                    'type' => ExchangePaymentMethodTypeEnum::OWNER_SELL->value,
                    'method_name' => $businessMethod->method_name,
                    'account_number' => $businessMethod->account_number,
                    'account_name' => $businessMethod->account_name,
                ]);
            }
        }

        return redirect()->route('exchange.posts')->with(['message' => 'Exchange Ad Edited Successfully']);
    }

    public function postsCreateTownlistAjax(Request $request)
    {
        $request->validate([
            'region_code' => 'required|exists:regions,code',
        ]);
        $towns = Towns::where('region_code', $request->get('region_code'))->get()->toArray();

        return [
            'status' => 200,
            'message' => 'successful',
            'data' => $towns,
        ];
    }

    public function postsCreateArealistAjax(Request $request)
    {
        $request->validate([
            'town_code' => 'required|exists:towns,code',
        ]);
        $towns = Area::where('town_code', $request->get('town_code'))->get()->toArray();

        return [
            'status' => 200,
            'message' => 'successful',
            'data' => $towns,
        ];
    }

    public function methods()
    {
        $user = \auth()->user();
        $dataTable = new DataTables();
        $builder = $dataTable->getHtmlBuilder();
        $paymentMethods = ExchangePaymentMethod::getAcceptedList($user->country_code);
        $exchangeBusinessMethods = ExchangeBusinessMethod::where('business_code', $user->business_code)->orderBy('id', 'desc');

        if (request()->ajax()) {

            return \Yajra\DataTables\Facades\DataTables::eloquent($exchangeBusinessMethods)
                ->addColumn('action', function (ExchangeBusinessMethod $trn) {
                    $content = '<button class="btn btn-secondary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#edit_method_modal" onclick="editClicked('.$trn->id.')">'.__('Edit').'</button>';
                    $content .= '<button class="btn btn-secondary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#delete_method_modal" onclick="deleteClicked('.$trn->id.')">'.__('Delete').'</button>';

                    return $content;
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->editColumn('status', function ($method) {
                    if ($method->status == 1) {
                        return 'active';
                    } else {
                        return 'inactive';
                    }
                })
                ->editColumn('id', function ($method) {
                    return idNumberDisplay($method->id);
                })
                ->toJson();
        }

        //Datatable
        $dataTableHtml = $builder->columns([
            ['data' => 'id', 'title' => __('id')],
            ['data' => 'nickname', 'title' => __('Nickname')],
            ['data' => 'method_name', 'title' => __('Method Name')],
            ['data' => 'account_number', 'title' => __('Account Number')],
            ['data' => 'account_name', 'title' => __('Account Name')],
            ['data' => 'status', 'title' => __('Status')],
            ['data' => 'action', 'title' => __('Action')],
        ])->responsive(true)
            ->ordering(false)
            ->ajax(route('exchange.methods'))
            ->paging(true)
            ->dom('frtilp')
            ->lengthMenu([[25, 50, 100, -1], [25, 50, 100, 'All']]);
        $methodsJson = $exchangeBusinessMethods->get()->toJson();

        return view('agent.exchange.methods', compact('dataTableHtml', 'paymentMethods', 'methodsJson'));
    }

    public function methodsAdd(Request $request)
    {
        $request->validate([
            'nickname' => 'required|string',
            'method_name' => 'required|string',
            'account_name' => 'required|string',
            'account_number' => 'required|alpha_num:ascii',
        ]);

        ExchangeBusinessMethod::create([
            'business_code' => $request->user()->business_code,
            'nickname' => $request->nickname,
            'method_name' => $request->method_name,
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
        ]);

        return redirect()->back()->with(['message' => __('Payment Method').' '.__('Added Successfully')]);
    }

    public function methodsEdit(Request $request)
    {
        $request->validate([
            'edit_id' => 'required|exists:exchange_business_methods,id',
            'edit_nickname' => 'required|string',
            'edit_method_name' => 'required|string',
            'edit_account_name' => 'required|string',
            'edit_account_number' => 'required|alpha_num:ascii',
        ]);

        $exchangeBusinessMethod = ExchangeBusinessMethod::where('id', $request->edit_id)->first();

        $isAllowed = $exchangeBusinessMethod->isUserAllowed($request->user());
        if ($isAllowed == false) {
            return redirect()->route('exchange.methods')->withErrors(['Not authorized to access method']);
        }

        $exchangeBusinessMethod->nickname = $request->edit_nickname;
        $exchangeBusinessMethod->method_name = $request->edit_method_name;
        $exchangeBusinessMethod->account_number = $request->edit_account_number;
        $exchangeBusinessMethod->account_name = $request->edit_account_name;
        $exchangeBusinessMethod->save();

        return redirect()->back()->with(['message' => __('Payment Method').' '.__('Edited Successfully')]);
    }

    public function methodsDelete(Request $request)
    {
        $request->validate([
            'delete_id' => 'required|exists:exchange_business_methods,id',
        ]);

        $exchangeBusinessMethod = ExchangeBusinessMethod::where('id', $request->delete_id)->first();

        $isAllowed = $exchangeBusinessMethod->isUserAllowed($request->user());
        if ($isAllowed == false) {
            return redirect()->route('exchange.methods')->withErrors(['Not authorized to access method']);
        }

        $exchangeBusinessMethod->delete();

        return redirect()->back()->with(['message' => __('Payment Method').' '.__('Deleted Successfully')]);
    }
}
