<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\ExchangeBusinessMethod;
use App\Models\Location;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Region;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class BusinessController extends Controller
{
    public function roles(Request $request)
    {
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
                    return '<a href="' . route('exchange.ads.view', $ad->id) . '" class="btn btn-secondary btn-sm">' . __("View Ad") . '</a>';
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
            ['data' => 'limit', 'title' => __('Limit in') . ' ' . strtoupper(session('currency'))],
            ['data' => 'payment', 'title' => __('Payment')],
            ['data' => 'trade', 'title' => __('general.exchange.trade')],
        ])->responsive(true)
            ->ordering(false)
            ->ajax(route('exchange.ads', $orderBy))
            ->paging(true)
            ->dom('frtilp')
            ->lengthMenu([[25, 50, 100, -1], [25, 50, 100, "All"]]);

        $regions = Region::where('country_code', session('country_code'))->get();

        return view('agent.business.ads', compact('dataTableHtml', 'stats', 'orderByFilter', 'regions'));
    }

    public function rolesCreate()
    {
        // $businessCode = \auth()->user()->business_code;
        // $branches = Location::where('business_code',$businessCode)->get();
        // $regions = Region::where('country_code',session('country_code'))->get();
        // $businessExchangeMethods = ExchangeBusinessMethod::where('business_code',$businessCode)->get();
        return view('agent.business.roles_create');
    }

    public function rolesCreateSubmit(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:3', 'unique:roles,name']
        ]);
        $roles = new Role();
        $roles->name = $request->name;
        $roles->guard_name = "web";
        $roles->save();
        return redirect()->route('exchange.posts')->with(['message' => 'Role create successfully.']);
    }

    public function profileCreate (Request $request){
        // dd('dd');
        $businessCode = \auth()->user()->business_code;
        $branches = Location::where('business_code',$businessCode)->get();
        $regions = Region::where('country_code',session('country_code'))->get();
        $businessExchangeMethods = ExchangeBusinessMethod::where('business_code',$businessCode)->get();

        return view('agent.business.profile_create', compact('branches','regions','businessExchangeMethods'));
    }
}
