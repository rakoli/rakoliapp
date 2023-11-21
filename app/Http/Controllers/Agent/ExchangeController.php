<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\ExchangeAds;
use App\Models\ExchangeStat;
use App\Models\SystemIncome;
use App\Utils\Enums\ExchangeStatusEnum;
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
                    $buyMethods = $ad->exchange_payment_methods->where('type',\App\Utils\Enums\ExchangePaymentMethodTypeEnum::OWNER_SEND->value);
                    $lastBuy = $buyMethods->last();
                    $sellMethods = $ad->exchange_payment_methods->where('type',\App\Utils\Enums\ExchangePaymentMethodTypeEnum::OWNER_RECEIVE->value);
                    $lastSell = $sellMethods->last();
                    return view('agent.exchange.ads_datatable_components._payment', compact( 'ad','buyMethods','sellMethods','lastBuy', 'lastSell'));
                })
                ->addColumn('trade', function(ExchangeAds $ad) {
                    return '<a href="'.route('exchange.ads.view',$ad->id).'" class="btn btn-light btn-sm">View Ad</a>';
                })
                ->rawColumns(['business_details','terms','limit','payment','trade'])
                ->addIndexColumn()
                ->toJson();
        }

        //Datatable
        $dataTableHtml = $builder->columns([
            ['data' => 'id', 'title' => __('id')],
            ['data' => 'business_details', 'title' => __('Business')],
            ['data' => 'terms', 'title' => __('Terms/Availability')],
            ['data' => 'limit' , 'title' => __('Limit'). ' '.strtoupper(session('currency'))],
            ['data' => 'payment', 'title' => __('Payment')],
            ['data' => 'trade', 'title' => __('Trade')],
        ])->orderBy(0,'desc');


        return view('agent.exchange.ads', compact('dataTableHtml','stats'));
    }

    public function adsView(Request $request, $id)
    {

        return $id;
    }

    public function orders()
    {

        return view('agent.exchange.orders');
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
