<?php

namespace App\Http\Controllers;

use App\DataTables\Admin\SystemIncomeDataTable;
use App\Models\Business;
use App\Models\ExchangeAds;
use App\Models\SystemIncome;
use App\Models\User;
use App\Models\VasPayment;
use App\Models\VasSubmission;
use App\Models\VasTask;
use App\Utils\Enums\UserTypeEnum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $stats = null;
        $dataTable = new DataTables();
        $builder = $dataTable->getHtmlBuilder();

        //ADMIN DASHBOARD
        if (auth()->user()->type == UserTypeEnum::ADMIN->value){
            //Datatable Data
            if (request()->ajax()) {

                $recentIncomes = SystemIncome::with('country')->
                    orderBy('id','desc')
                    ->take(10)->get();

                return \Yajra\DataTables\Facades\DataTables::of($recentIncomes)
                    ->addColumn('amt',
                    function($recentIncome){
                        return number_format($recentIncome->amount,2) . ' '.$recentIncome->amount_currency;
                    })->toJson();
            }

            //Datatable
            $dataTableHtml = $builder->columns([
                ['data' => 'id' ],
                ['data' => 'country.name', 'title' => 'Country'],
                ['data' => 'category'],
                ['data' => 'amt' , 'title' => 'Amount'],
                ['data' => 'channel'],
                ['data' => 'channel_reference'],
                ['data' => 'channel_timestamp'],
            ])->orderBy(0,'desc');

            //Dashboard Statistics
            $businesses = Business::get();
            $stats['business'] = $businesses->count();
            $stats['total_income'] = SystemIncome::where('status', \App\Utils\Enums\SystemIncomeStatusEnum::RECEIVED->value)->get()->sum('amount');
            $stats['exchange_listings'] = ExchangeAds::count();
            $stats['vas_listings'] = VasTask::count();
            $stats['active_subscription'] = $businesses->whereNotNull('package_code')->count();
            $stats['users'] = User::count();

            return view('dashboard.admin', compact('dataTableHtml','stats'));
        }


        //VAS DASHBOARD
        if (auth()->user()->type == UserTypeEnum::VAS->value){
            //Datatable Data
            if (request()->ajax()) {
                $payments = Business::where('code',auth()->user()->business_code)->first()
                    ->vasPaymentsDone()
                    ->with('contract')
                    ->with('payee')
                    ->take(10)->get();

                return \Yajra\DataTables\Facades\DataTables::of($payments)
                    ->editColumn('created_at', function($payment) {
                        return Carbon::parse($payment->created_at)->toDateTimeString();
                    })
                    ->addColumn('amt',
                    function($payment){
                        return number_format($payment->amount,2) . ' '.$payment->amount_currency;
                    })->toJson();
            }

            //Datatable
            $dataTableHtml = $builder->columns([
                ['data' => 'created_at', 'title'=> 'Time' ],
                ['data' => 'contract.title', 'title'=> 'Contract'],
                ['data' => 'payee.business_name', 'title'=> 'Contractor'],
                ['data' => 'amt', 'title'=>'Currency'],
            ])->orderBy(0,'desc');

            //Dashboard Statistics
            $stats['total_services'] = VasTask::where('vas_provider_code',auth()->user()->business_code)->count();
            $stats['total_submission'] = Business::where('code',auth()->user()->business_code)->first()->agentsSubmissions()->count();
            $stats['users'] = User::where('business_code',auth()->user()->business_code)->count();
            $stats['payments_made'] = VasPayment::where('business_code',auth()->user()->business_code)->get()->sum('amount');

            return view('dashboard.vas', compact('dataTableHtml','stats'));
        }


        //AGENT DASHBOARD
        if (auth()->user()->type == UserTypeEnum::AGENT->value){


            return view('dashboard.agent');
        }

        return 'INVALID DASHBOARD REQUEST';
    }

    public function registrationAgent()
    {

        return view('auth.registration_agent.index');
    }

    public function registrationVas()
    {

        return view('auth.registration_vas.index');
    }
}
