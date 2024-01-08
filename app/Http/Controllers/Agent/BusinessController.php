<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\ExchangeAds;
use App\Models\ExchangeBusinessMethod;
use App\Models\Location;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Region;
use App\Models\Role;
use App\Utils\Enums\ExchangeStatusEnum;
use Illuminate\Support\Facades\Auth;

class BusinessController extends Controller
{
    public function roles(Request $request)
    {
        $dataTable = new DataTables();
        $builder = $dataTable->getHtmlBuilder();
        $orderBy = null;
        $orderByFilter = null;
    
        if ($request->get('order_by')) {
            $orderBy = ['order_by' => $request->get('order_by')];
            $orderByFilter = $request->get('order_by');
        }
    
        if (request()->ajax()) {
            $roles = Role::query(); // Assuming you have a Role model associated with the roles table
    
            return \Yajra\DataTables\Facades\DataTables::eloquent($roles)
                ->addColumn('actions', function (Role $role) {
                    // Add any additional actions you want for each role
                    return '<a href="#" class="btn btn-secondary btn-sm">Edit</a>';
                })
                ->rawColumns(['actions'])
                ->addIndexColumn()
                ->toJson();
        }
    
        // DataTable
        $dataTableHtml = $builder->columns([
            ['data' => 'id', 'title' => __('ID')],
            ['data' => 'name', 'title' => __('Name')],
            ['data' => 'guard_name', 'title' => __('Guard Name')],
            ['data' => 'actions', 'title' => __('Actions')],
        ])->responsive(true)
            ->ordering(false)
            ->ajax(route('business.role', $orderBy)) // Assuming you have a named route for the roles.index endpoint
            ->paging(true)
            ->dom('frtilp')
            ->lengthMenu([[25, 50, 100, -1], [25, 50, 100, "All"]]);
    
        return view('agent.business.ads',compact('dataTableHtml', 'orderByFilter'));
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
        return redirect()->route('business.role')->with(['message' => 'Role create successfully.']);
    }

    public function profileCreate(Request $request)
    {
        $businessCode = \auth()->user();
        $user = auth()->user();
        $business = $user->business;
        // $branches = Location::where('business_code',$businessCode)->get();
        // $regions = Region::where('country_code',session('country_code'))->get();
        // $businessExchangeMethods = ExchangeBusinessMethod::where('business_code',$businessCode)->get();

        return view('agent.business.profile_create', compact('business'));
    }
        public function branches(Request $request)
        {
            $user = \auth()->user();
            $dataTable = new DataTables();
            $builder = $dataTable->getHtmlBuilder();

            if (request()->ajax()){
                $exchangePosts = ExchangeAds::where('business_code',$user->business_code)->orderBy('id','desc')->with('exchange_payment_methods');
                return \Yajra\DataTables\Facades\DataTables::eloquent($exchangePosts)
                    ->addColumn('action', function(ExchangeAds $trn) {
                        $content = '<a class="btn btn-secondary btn-sm me-2" href="'.route('exchange.posts.edit', $trn->id).'">'.__("Edit").'</a>';
                        if($trn->status != ExchangeStatusEnum::DELETED->value){
                            $content .= '<button class="btn btn-secondary btn-sm me-2" onclick="deleteClicked('.$trn->id.')">'.__("Delete").'</button>';
                        }
                        return $content;
                    })
                    ->addColumn('range', function(ExchangeAds $trn) {
                        $min = number_format($trn->min_amount);
                        $max = number_format($trn->max_amount);
                        return "$min to $max";
                    })
                    ->addColumn('payment', function(ExchangeAds $ad) {
                        $ownerSellMethods = $ad->exchange_payment_methods->where('type',\App\Utils\Enums\ExchangePaymentMethodTypeEnum::OWNER_SELL->value)->where('status',1);
                        $ownerBuyMethods = $ad->exchange_payment_methods->where('type',\App\Utils\Enums\ExchangePaymentMethodTypeEnum::OWNER_BUY->value)->where('status',1);

                        $traderSellMethods = $ownerSellMethods;//To match view display, should be opposite since is owner load
                        $lastTraderSell = $traderSellMethods->last();

                        $traderBuyMethods = $ownerBuyMethods;//To match view display, should be opposite since is owner load
                        $lastTraderBuy = $traderBuyMethods->last();
                        return view('agent.exchange.ads_datatable_components._payment', compact( 'ad','traderSellMethods','traderBuyMethods','lastTraderSell', 'lastTraderBuy'));
                    })
                    ->addIndexColumn()
                    ->rawColumns(['action'])
                    ->editColumn('id',function($method) {
                        return idNumberDisplay($method->id);
                    })
                    ->editColumn('location',function($method) {
                        return $method->location->name;
                    })
                    ->toJson();
            }

            //Datatable
            $dataTableHtml = $builder->columns([
                ['data' => 'id', 'title' => __('id')],
                ['data' => 'name', 'title' => __("Name")],
                ['data' => 'balance', 'title' => __("Balance").' ('.session('currency').')'],
                ['data' => 'balance_currency ', 'title' => __("Balance Currency ")],
                ['data' => 'description', 'title' => __("Description")],
                ['data' => 'action', 'title' => __("Action")],
            ])->responsive(true)
                ->ordering(false)
                ->ajax(route('business.branches'))
                ->paging(true)
                ->dom('frtilp')
                ->lengthMenu([[25, 50, 100, -1], [25, 50, 100, "All"]]);

            return view('agent.business.branches',compact('dataTableHtml'));
        }

}
