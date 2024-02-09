<?php

namespace App\Http\Controllers\Agent;

use App\Actions\CheckUserPendingSystemPayments;
use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\InitiatedPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SubscriptionController extends Controller
{
    public function subscription(Request $request)
    {
        $user = \auth()->user();
        $dataTable = new DataTables();
        $builder = $dataTable->getHtmlBuilder();

        $subscriptionPayments = InitiatedPayment::where('business_code', $user->business_code)->orderBy('id', 'desc');
        $business = Business::where('code', $user->business_code)->with('package')->with('package.featuresAvailable')->with('package.featuresAvailable.feature')->first();
        $currency = session('currency');

        if (request()->ajax()) {
            return \Yajra\DataTables\Facades\DataTables::eloquent($subscriptionPayments)
            // ->addColumn('actions', function(Transaction $role) {
            //     $content = '<button class="btn btn-secondary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#edit_method_modal" onclick="editClicked('.$role->id.')">'.__("Edit").'</button>';
            //     $content .= '<button class="btn btn-secondary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#delete_method_modal" onclick="deleteClicked('.$role->id.')">'.__("Delete").'</button>';
            //     return $content;
            // })
            // ->rawColumns(['actions'])
                ->addColumn('amount_display', function ($row) {
                    return number_format($row->amount, 2).' '.strtoupper($row->amount_currency);
                })
                ->editColumn('created_at', function ($trn) {
                    return Carbon::create($trn->created_at)->toDateTimeString('minute');
                })
                ->addIndexColumn()
                ->toJson();
        }

        // DataTable
        $dataTableHtml = $builder->columns([
            ['data' => 'created_at', 'title' => __('Time')],
            ['data' => 'channel', 'title' => __('Channel')],
            ['data' => 'income_category', 'title' => __('Income Category')],
            ['data' => 'amount_display', 'title' => __('Amount')],
            ['data' => 'status', 'title' => __('Status')],
            ['data' => 'channel_ref_name', 'title' => __('Channel')],
            ['data' => 'channel_ref', 'title' => __('Reference')],
        ])->responsive(true)
            ->ordering(false)
            ->ajax(route('business.subscription')) // Assuming you have a named route for the roles.index endpoint
            ->paging(true)
            ->dom('frtilp')
            ->lengthMenu([[5, 10, 20, -1], [5, 10, 20, 'All']]);

        $hasPendingPayment = false;
        $initiatedPayments = auth()->user()->getBusinessPendingPayments();
        if (! $initiatedPayments->isEmpty()) {
            $hasPendingPayment = true;
            CheckUserPendingSystemPayments::run(auth()->user(), $initiatedPayments);
        }

        return view('agent.business.subscription', compact('dataTableHtml', 'currency', 'business', 'hasPendingPayment', 'initiatedPayments'));
    }

    public function subscriptionBuy(Request $request)
    {
        return view('agent.business.subscription_buy');
    }
}
