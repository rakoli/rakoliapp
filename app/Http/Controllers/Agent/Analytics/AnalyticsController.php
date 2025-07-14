<?php

namespace App\Http\Controllers\Agent\Analytics;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Shift;
use App\Models\ShiftTransaction;
use App\Models\User;
use App\Models\Location;
use App\Utils\Enums\ShiftStatusEnum;
use App\Utils\Enums\TransactionTypeEnum;
use App\Utils\Enums\UserTypeEnum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $business = auth()->user()->business;
        $user = auth()->user();

        // Get analytics data
        $analyticsData = $this->getAnalyticsData($business, $user, $request);

        return view('agent.analytics.index', compact('analyticsData'));
    }

    public function shifts(Request $request)
    {
        $business = auth()->user()->business;
        $user = auth()->user();

        if ($request->ajax()) {
            $shifts = Shift::with(['user', 'location'])
                ->where('business_code', $business->code)
                ->when($request->filled('date_from'), function($query) use ($request) {
                    return $query->whereDate('created_at', '>=', $request->date_from);
                })
                ->when($request->filled('date_to'), function($query) use ($request) {
                    return $query->whereDate('created_at', '<=', $request->date_to);
                })
                ->when($request->filled('user_code'), function($query) use ($request) {
                    return $query->where('user_code', $request->user_code);
                })
                ->when($request->filled('location_code'), function($query) use ($request) {
                    return $query->where('location_code', $request->location_code);
                })
                ->when($request->filled('status'), function($query) use ($request) {
                    return $query->where('status', $request->status);
                })
                ->orderBy('created_at', 'desc');

            return DataTables::of($shifts)
                ->addColumn('user_name', function($shift) {
                    return $shift->user ? $shift->user->name : 'N/A';
                })
                ->addColumn('user_email', function($shift) {
                    return $shift->user ? $shift->user->email : 'N/A';
                })
                ->addColumn('location_name', function($shift) {
                    return $shift->location ? $shift->location->name : 'N/A';
                })
                ->addColumn('duration', function($shift) {
                    if ($shift->status === ShiftStatusEnum::OPEN) {
                        return Carbon::parse($shift->created_at)->diffForHumans();
                    }
                    return Carbon::parse($shift->created_at)->diffInHours(Carbon::parse($shift->updated_at)) . ' hours';
                })
                ->addColumn('transactions_count', function($shift) {
                    return $shift->transactions()->count();
                })
                ->addColumn('total_amount', function($shift) {
                    return number_format($shift->transactions()->sum('amount'), 2);
                })
                ->addColumn('status_badge', function($shift) {
                    $badgeClass = $shift->status === ShiftStatusEnum::OPEN ? 'badge-success' : 'badge-secondary';
                    return '<span class="badge ' . $badgeClass . '">' . $shift->status->value . '</span>';
                })
                ->addColumn('action', function($shift) {
                    return '<a href="' . route('agency.shift.show', $shift->id) . '" class="btn btn-sm btn-primary">View</a>';
                })
                ->rawColumns(['status_badge', 'action'])
                ->make(true);
        }

        $users = User::where('business_code', $business->code)
            ->where('type', UserTypeEnum::AGENT)
            ->get();

        $locations = Location::where('business_code', $business->code)->get();

        return view('agent.analytics.shifts', compact('users', 'locations'));
    }

    public function transactions(Request $request)
    {
        $business = auth()->user()->business;

        // Get transactions data directly
        $transactions = ShiftTransaction::with(['user', 'location', 'shift', 'network'])
            ->where('business_code', $business->code)
            ->when($request->filled('date_from'), function($query) use ($request) {
                return $query->whereDate('created_at', '>=', $request->date_from);
            })
            ->when($request->filled('date_to'), function($query) use ($request) {
                return $query->whereDate('created_at', '<=', $request->date_to);
            })
            ->when($request->filled('user_code'), function($query) use ($request) {
                return $query->where('user_code', $request->user_code);
            })
            ->when($request->filled('location_code'), function($query) use ($request) {
                return $query->where('location_code', $request->location_code);
            })
            ->when($request->filled('type'), function($query) use ($request) {
                return $query->where('type', $request->type);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        $users = User::where('business_code', $business->code)
            ->where('type', UserTypeEnum::AGENT)
            ->get();

        $locations = Location::where('business_code', $business->code)->get();

        return view('agent.analytics.transactions', compact('transactions', 'users', 'locations'));
    }

    public function users(Request $request)
    {
        $business = auth()->user()->business;

        // Get user analytics data
        $userAnalytics = $this->getUserAnalytics($business, $request);

        return view('agent.analytics.users', compact('userAnalytics'));
    }

    private function getAnalyticsData($business, $user, $request)
    {
        $dateRange = $this->getDateRange($request);

        // Basic statistics
        $totalShifts = Shift::where('business_code', $business->code)
            ->whereBetween('created_at', $dateRange)
            ->count();

        $openShifts = Shift::where('business_code', $business->code)
            ->where('status', ShiftStatusEnum::OPEN)
            ->count();

        $closedShifts = Shift::where('business_code', $business->code)
            ->where('status', ShiftStatusEnum::CLOSED)
            ->whereBetween('created_at', $dateRange)
            ->count();

        $totalTransactions = ShiftTransaction::where('business_code', $business->code)
            ->whereBetween('created_at', $dateRange)
            ->count();

        $totalAmount = ShiftTransaction::where('business_code', $business->code)
            ->whereBetween('created_at', $dateRange)
            ->sum('amount');

        $moneyIn = ShiftTransaction::where('business_code', $business->code)
            ->where('type', TransactionTypeEnum::MONEY_IN)
            ->whereBetween('created_at', $dateRange)
            ->sum('amount');

        $moneyOut = ShiftTransaction::where('business_code', $business->code)
            ->where('type', TransactionTypeEnum::MONEY_OUT)
            ->whereBetween('created_at', $dateRange)
            ->sum('amount');

        // Chart data for shifts over time
        $shiftsChart = $this->getShiftsChartData($business, $dateRange);

        // Chart data for transactions over time
        $transactionsChart = $this->getTransactionsChartData($business, $dateRange);

        // Top performing users
        $topUsers = $this->getTopUsers($business, $dateRange);

        // Location performance
        $locationPerformance = $this->getLocationPerformance($business, $dateRange);

        return [
            'totalShifts' => $totalShifts,
            'openShifts' => $openShifts,
            'closedShifts' => $closedShifts,
            'totalTransactions' => $totalTransactions,
            'totalAmount' => $totalAmount,
            'moneyIn' => $moneyIn,
            'moneyOut' => $moneyOut,
            'netAmount' => $moneyIn - $moneyOut,
            'shiftsChart' => $shiftsChart,
            'transactionsChart' => $transactionsChart,
            'topUsers' => $topUsers,
            'locationPerformance' => $locationPerformance,
            'dateRange' => $dateRange,
            'currency' => $business->country->currency
        ];
    }

    private function getDateRange($request)
    {
        $dateFrom = $request->input('date_from', Carbon::now()->subDays(30)->format('Y-m-d'));
        $dateTo = $request->input('date_to', Carbon::now()->format('Y-m-d'));

        return [
            Carbon::parse($dateFrom)->startOfDay(),
            Carbon::parse($dateTo)->endOfDay()
        ];
    }

    private function getShiftsChartData($business, $dateRange)
    {
        $shifts = Shift::where('business_code', $business->code)
            ->whereBetween('created_at', $dateRange)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(CASE WHEN status = "' . ShiftStatusEnum::OPEN->value . '" THEN 1 ELSE 0 END) as open_count'),
                DB::raw('SUM(CASE WHEN status = "' . ShiftStatusEnum::CLOSED->value . '" THEN 1 ELSE 0 END) as closed_count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'dates' => $shifts->pluck('date'),
            'total' => $shifts->pluck('count'),
            'open' => $shifts->pluck('open_count'),
            'closed' => $shifts->pluck('closed_count')
        ];
    }

    private function getTransactionsChartData($business, $dateRange)
    {
        $transactions = ShiftTransaction::where('business_code', $business->code)
            ->whereBetween('created_at', $dateRange)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(amount) as total_amount'),
                DB::raw('SUM(CASE WHEN type = "' . TransactionTypeEnum::MONEY_IN->value . '" THEN amount ELSE 0 END) as money_in'),
                DB::raw('SUM(CASE WHEN type = "' . TransactionTypeEnum::MONEY_OUT->value . '" THEN amount ELSE 0 END) as money_out')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'dates' => $transactions->pluck('date'),
            'count' => $transactions->pluck('count'),
            'total_amount' => $transactions->pluck('total_amount'),
            'money_in' => $transactions->pluck('money_in'),
            'money_out' => $transactions->pluck('money_out')
        ];
    }

    private function getTopUsers($business, $dateRange)
    {
        return User::where('business_code', $business->code)
            ->where('type', UserTypeEnum::AGENT)
            ->withCount(['shifts' => function($query) use ($dateRange) {
                $query->whereBetween('created_at', $dateRange);
            }])
            ->withSum(['shift_transactions' => function($query) use ($dateRange) {
                $query->whereBetween('created_at', $dateRange);
            }], 'amount')
            ->orderByDesc('shifts_count')
            ->take(5)
            ->get();
    }

    private function getLocationPerformance($business, $dateRange)
    {
        return Location::where('business_code', $business->code)
            ->withCount(['shifts' => function($query) use ($dateRange) {
                $query->whereBetween('created_at', $dateRange);
            }])
            ->withSum(['shift_transactions' => function($query) use ($dateRange) {
                $query->whereBetween('created_at', $dateRange);
            }], 'amount')
            ->orderByDesc('shifts_count')
            ->get();
    }

    private function getUserAnalytics($business, $request)
    {
        $dateRange = $this->getDateRange($request);

        return User::where('business_code', $business->code)
            ->where('type', UserTypeEnum::AGENT)
            ->with(['shifts' => function($query) use ($dateRange) {
                $query->whereBetween('created_at', $dateRange);
            }])
            ->withCount(['shifts' => function($query) use ($dateRange) {
                $query->whereBetween('created_at', $dateRange);
            }])
            ->withSum(['shift_transactions' => function($query) use ($dateRange) {
                $query->whereBetween('created_at', $dateRange);
            }], 'amount')
            ->withAvg(['shifts' => function($query) use ($dateRange) {
                $query->whereBetween('created_at', $dateRange);
            }], 'cash_end')
            ->get()
            ->map(function($user) use ($dateRange) {
                $totalHours = $user->shifts->sum(function($shift) {
                    if ($shift->status === ShiftStatusEnum::OPEN) {
                        return Carbon::parse($shift->created_at)->diffInHours(Carbon::now());
                    }
                    return Carbon::parse($shift->created_at)->diffInHours(Carbon::parse($shift->updated_at));
                });

                $user->total_hours = $totalHours;
                $user->avg_shift_duration = $user->shifts_count > 0 ? $totalHours / $user->shifts_count : 0;

                return $user;
            });
    }
}
