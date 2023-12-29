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
            $stats['total_services'] = VasTask::where('vas_business_code',$user->business_code)->count();
            $stats['total_submission'] = Business::where('code',$user->business_code)->first()->agentsSubmissions()->count();
            $stats['users'] = User::where('business_code',$user->business_code)->count();
            $stats['payments_made'] = VasPayment::where('business_code',$user->business_code)->get()->sum('amount');

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
            $stats['networks'] = Network::where('business_code',$user->business_code)->get()->count();
            $stats['open_shifts'] = Shift::where(['status'=>ShiftStatusEnum::OPEN,'business_code'=>$user->business_code])->get()->count();

            $cashBalance = Location::where('business_code',$user->business_code)->get()->sum('balance');
            $tillBalance = Network::where('business_code',$user->business_code)->get()->sum('balance');
            $stats['cash_balance'] = number_format($cashBalance);
            $stats['till_balance'] = number_format($tillBalance);
            $stats['total_location_balance'] = number_format($cashBalance + $tillBalance);

            $stats['awarded_vas'] = VasContract::where('agent_business_code', $user->business_code)->get()->count();
            $stats['pending_exchange'] = ExchangeTransaction::where([
                'trader_business_code' => $user->business_code,
                'status' => ExchangeTransactionStatusEnum::OPEN
            ])->orWhere(function (\Illuminate\Database\Eloquent\Builder $query) {
                    $query->where('owner_business_code', auth()->user()->business_code)
                        ->where('status', ExchangeTransactionStatusEnum::OPEN);
                })->get()->count(); // where (trader_business_code AND status) OR (owner_business_code AND status)

            $stats['highlights']['income'] = number_format(Transaction::where([
                'business_code' => $user->business_code,
                'category' => TransactionCategoryEnum::INCOME,
            ])->where('created_at','>=',now()->subDays(30))->get()->sum('amount'));

            $stats['highlights']['expense'] = number_format(Transaction::where([
                'business_code' => $user->business_code,
                'category' => TransactionCategoryEnum::EXPENSE,
            ])->where('created_at','>=',now()->subDays(30))->get()->sum('amount'));

            $stats['highlights']['referrals'] = number_format(Business::where('referral_business_code', $user->business_code)->get()->count());

            return view('dashboard.agent',compact('dataTableHtml','stats'));
        }

        return 'INVALID DASHBOARD REQUEST';
    }

}
