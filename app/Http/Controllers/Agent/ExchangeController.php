<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\ExchangeAds;
use App\Models\ExchangePaymentMethod;
use App\Models\ExchangeStat;
use App\Models\ExchangeTransaction;
use App\Models\SystemIncome;
use App\Utils\Enums\ExchangeStatusEnum;
use App\Utils\Enums\ExchangeTransactionStatusEnum;
use App\Utils\Enums\ExchangeTransactionTypeEnum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ExchangeController extends Controller
{
    public function ads()
    {
        $stats = null;
        $dataTable = new DataTables();
        $builder = $dataTable->getHtmlBuilder();

        if (request()->ajax()) {

            $ads = ExchangeAds::where('status', ExchangeStatusEnum::ACTIVE->value)
                ->with('exchange_payment_methods')
                ->with('business')
                ->limit(50)->get();

            return \Yajra\DataTables\Facades\DataTables::of($ads)
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
        ])->responsive(true)->ordering(false)->info();


        return view('agent.exchange.ads', compact('dataTableHtml','stats'));
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
        $exchange = ExchangeAds::where('id',$request->get('exchange_id'))->first();
        $request->validate([
            'exchange_id' => 'required|exists:exchange_ads,id',
            'action_select' => 'required|in:'.implode(',',ExchangeTransactionTypeEnum::toArray()),
            'action_method_select' => 'required|exists:exchange_payment_methods,id',
            'action_for_select' => 'required|exists:exchange_payment_methods,id',
            'amount' => 'required|numeric|min:'.$exchange->min_amount.'|max:'.$exchange->max_amount,
            'comment' => 'sometimes|string',
        ]);
        $exchangeCode = $exchange->code;

        $ams = ExchangePaymentMethod::where('id',$request->get('action_method_select'))->first();
        $trader = ExchangePaymentMethod::where('id',$request->get('action_for_select'))->first();

        $exchangeTransaction = ExchangeTransaction::create([
            'exchange_ads_code' => $exchangeCode,
            'owner_business_code' => $exchange->business->code,
            'trader_business_code' => $request->user()->business->code,
            'trader_action_type' => $request->get('action_select'),
            'trader_action_method_id' => $ams->id,
            'trader_action_method' => $ams->method_name,
            'for_method' => $trader->method_name,
            'amount' => $request->get('amount'),
            'amount_currency' => session('currency'),
            'status' => ExchangeTransactionStatusEnum::OPEN,
            'trader_comments' => $request->get('comment'),
        ]);

        return [
            'success'           => true,
            'result'            => "successful",
            'resultExplanation' => "Order created successfully",
            'orderid' => $exchangeTransaction->id,
        ];
    }

    public function orders()
    {

        return view('agent.exchange.orders');
    }

    public function ordersView(Request $request, $id)
    {

        dd($id, $request);

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
