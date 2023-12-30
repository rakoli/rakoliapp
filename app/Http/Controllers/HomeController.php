<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\ExchangeAds;
use App\Models\ExchangeTransaction;
use App\Models\Location;
use App\Models\Network;
use App\Models\Shift;
use App\Models\SystemIncome;
use App\Models\Transaction;
use App\Models\User;
use App\Models\VasContract;
use App\Models\VasPayment;
use App\Models\VasSubmission;
use App\Models\VasTask;
use App\Utils\Enums\ExchangeTransactionStatusEnum;
use App\Utils\Enums\ShiftStatusEnum;
use App\Utils\Enums\TransactionCategoryEnum;
use App\Utils\Enums\UserTypeEnum;
use App\Utils\StatisticsService;
use Carbon\Carbon;
use DebugBar\DebugBar;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $stats = null;
        $dataTable = new DataTables();
        $builder = $dataTable->getHtmlBuilder();
        $user = auth()->user();
        $statisticsService = new StatisticsService($user);

        //ADMIN DASHBOARD
        if ($user->type == UserTypeEnum::ADMIN->value){
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
                ['data' => 'country.name', 'title' => __('Country')],
                ['data' => 'category', 'title' => __('Category')],
                ['data' => 'amt' , 'title' => __('Amount')],
                ['data' => 'channel', 'title' => __('Channel')],
                ['data' => 'channel_reference', 'title' => __('Channel Reference')],
                ['data' => 'channel_timestamp', 'title' => __('Channel Time')],
            ])->orderBy(0,'desc')
                ->responsive(true)
                ->setTableHeadClass('fw-semibold fs-6 text-gray-800 border-bottom border-gray-200');

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
        if ($user->type == UserTypeEnum::VAS->value){
            //Datatable Data
            if (request()->ajax()) {
                $payments = Business::where('code',$user->business_code)->first()
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
                ['data' => 'created_at', 'title'=> __('Time') ],
                ['data' => 'contract.title', 'title'=> __('Contract')],
                ['data' => 'payee.business_name', 'title'=> __('Contractor')],
                ['data' => 'amt', 'title'=> __('Amount')],
            ])->orderBy(0,'desc')
                ->responsive(true)
                ->setTableHeadClass('fw-semibold fs-6 text-gray-800 border-bottom border-gray-200');

            //Dashboard Statistics
            $stats['total_services'] = $statisticsService->vas_total_services_posted();
            $stats['total_submission'] = $statisticsService->vas_total_received_submissions();
            $stats['users'] = $statisticsService->vas_no_of_users_in_business();
            $stats['payments_made'] = $statisticsService->vas_total_payments_made();

            return view('dashboard.vas', compact('dataTableHtml','stats'));
        }


        //AGENT DASHBOARD
        if ($user->type == UserTypeEnum::AGENT->value){
            //Datatable Data
            if (request()->ajax()) {
                $recentTransactions = Transaction::where('business_code', $user->business_code)
                    ->with('location')
                    ->with('user')
                    ->orderBy('id','desc')
                    ->take(10)->get();

                return \Yajra\DataTables\Facades\DataTables::of($recentTransactions)
                    ->editColumn('amount', function($payment) {
                        return number_format($payment->amount,2). ' '.$payment->amount_currency;
                    })
                    ->editColumn('balance_new', function($payment) {
                        return number_format($payment->balance_new,2). ' '.$payment->amount_currency;
                    })
                    ->editColumn('created_at', function($payment) {
                        return Carbon::parse($payment->created_at)->toDateTimeString();
                    })
                    ->addColumn('name',
                        function($payment){
                            return $payment->user->fname .' '.$payment->user->lname;
                        })
                    ->toJson();
            }

            //Datatable
            $dataTableHtml = $builder->columns([
                ['data' => 'created_at', 'title'=> __('Time') ],
                ['data' => 'location.name', 'title'=> __('Location')],
                ['data' => 'name', 'title'=> __('User')],
                ['data' => 'type', 'title'=> __('Type')],
                ['data' => 'amount', 'title'=> __('Amount')],
                ['data' => 'balance_new' , 'title'=> __('Balance')],
            ])->orderBy(0,'desc')
                ->responsive(true)
                ->setTableHeadClass('fw-semibold fs-6 text-gray-800 border-bottom border-gray-200');

            //Dashboard Statistics
            $stats['networks'] = $statisticsService->noOfBusinessNetworks();
            $stats['open_shifts'] = $statisticsService->noOfBusinessOpenShifts();

            $cashBalance = $statisticsService->businessTotalCashBalance();
            $tillBalance = $statisticsService->businessTotalTillBalance();
            $stats['cash_balance'] = number_format($cashBalance);
            $stats['till_balance'] = number_format($tillBalance);
            $stats['total_location_balance'] = number_format($cashBalance + $tillBalance);

            $stats['awarded_vas'] = $statisticsService->agentNoOfAwardedVasContract();
            $stats['pending_exchange'] =  $statisticsService->agentNoOfPendingExchange();// where (trader_business_code AND status) OR (owner_business_code AND status)

            $stats['highlights']['income'] = number_format($statisticsService->businessIncomeTotalof30days());

            $stats['highlights']['expense'] = number_format($statisticsService->businessExpenseTotalof30days());

            $stats['highlights']['referrals'] = number_format($statisticsService->businessNoOfReferrals());

            return view('dashboard.agent',compact('dataTableHtml','stats'));
        }

        return 'INVALID DASHBOARD REQUEST';
    }

}
