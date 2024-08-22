<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessWithdrawMethod;
use App\Models\InitiatedPayment;
use App\Models\Package;
use App\Models\PackageName;
use App\Models\Region;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SubscriptionController extends Controller
{
    public function subscription(Request $request)
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
        $roles = InitiatedPayment::where('business_code', $user->business_code)->orderBy('id', 'desc');
        $balance = Business::where('code', $user->business_code)->with('package')->with('package.featuresAvailable')->with('package.featuresAvailable.feature')->get();
        // dd($balance[0]->package->featuresAvailable[0]->feature);
        $country_code = session('country_code');
        $currency = session('currency');
        $packages = Package::where('country_code', $country_code)->where('status',1)->get();
        $existingData = BusinessWithdrawMethod::where('business_code', $user->business_code)->get();

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
            ['data' => 'channel', 'title' => __('Channel')],
            ['data' => 'income_category', 'title' => __('Income Category')],
            ['data' => 'amount', 'title' => __('Amount')],
            ['data' => 'status', 'title' => __('Status')],
            ['data' => 'channel_ref_name', 'title' => __('Channel Ref Name')],
            // ['data' => 'amount_currency', 'title' => __('Amount Currency')],
            // ['data' => 'description', 'title' => __('Description')],
            // ['data' => 'note', 'title' => __('Note')],
            // ['data' => 'actions', 'title' => __('Actions')],
        ])->responsive(true)
            ->ordering(false)
            ->ajax(route('business.subscription', $orderBy)) // Assuming you have a named route for the roles.index endpoint
            ->paging(true)
            ->dom('frtilp')
            ->lengthMenu([[25, 50, 100, -1], [25, 50, 100, "All"]]);

        $methodsJson = $roles->get()->toJson();
        return view('agent.business.subsciption', compact('dataTableHtml', 'orderByFilter','currency', 'methodsJson', 'balance','existingData','packages','country_code'));
    }

    public function subscriptionBuy(Request $request){
        return view('agent.business.buy_subscription');
    }
}
