<?php

namespace App\Http\Controllers\Admin\Analytics;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Shift;
use App\Models\ShiftTransaction;
use App\Models\User;
use App\Models\Location;
use App\Models\Country;
use App\Utils\Enums\ShiftStatusEnum;
use App\Utils\Enums\TransactionTypeEnum;
use App\Utils\Enums\UserTypeEnum;
use App\Utils\Enums\UserStatusEnum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

/**
 * Admin Analytics Controller
 *
 * This controller provides analytics functionality exclusively for admin users.
 *
 * Security Measures:
 * 1. Routes are protected by 'onlyadmin' middleware in routes/custom-admin.php
 * 2. Additional constructor middleware checks user type for defense in depth
 * 3. All views extend admin layout ensuring proper UI context
 * 4. Separate from agent analytics to prevent cross-access
 */
class AdminAnalyticsController extends Controller
{
    public function index(Request $request)
    {
        // Get system-wide analytics data
        $analyticsData = $this->getSystemAnalyticsData($request);

        return view('admin.analytics.index', compact('analyticsData'));
    }

    public function businesses(Request $request)
    {
        // Get paginated businesses based on filters
        $businesses = Business::with(['country', 'users'])
            ->when($request->filled('date_from'), function($query) use ($request) {
                return $query->whereDate('created_at', '>=', $request->date_from);
            })
            ->when($request->filled('date_to'), function($query) use ($request) {
                return $query->whereDate('created_at', '<=', $request->date_to);
            })
            ->when($request->filled('country_code'), function($query) use ($request) {
                return $query->where('country_code', $request->country_code);
            })
            ->when($request->filled('status'), function($query) use ($request) {
                return $query->where('is_verified', $request->status);
            })
            ->withCount([
                'shifts' => function($query) use ($request) {
                    if ($request->filled('date_from') && $request->filled('date_to')) {
                        $query->whereBetween('created_at', [
                            Carbon::parse($request->date_from)->startOfDay(),
                            Carbon::parse($request->date_to)->endOfDay()
                        ]);
                    }
                },
                'users' => function($query) {
                    $query->where('type', UserTypeEnum::AGENT);
                }
            ])
            ->withSum([
                'business_account_transactions' => function($query) use ($request) {
                    if ($request->filled('date_from') && $request->filled('date_to')) {
                        $query->whereBetween('created_at', [
                            Carbon::parse($request->date_from)->startOfDay(),
                            Carbon::parse($request->date_to)->endOfDay()
                        ]);
                    }
                }
            ], 'amount')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $countries = Country::all();

        return view('admin.analytics.businesses', compact('businesses', 'countries'));
    }

    public function shifts(Request $request)
    {
        // Get filter options
        $businesses = Business::select('code', 'business_name as name')->get();
        $locations = Location::select('id', 'name')->get();

        // Get summary data for shifts
        $summaryData = $this->getShiftsSummaryData($request);

        // Get chart data for dashboard
        $chartData = $this->getShiftsChartData($request);

        return view('admin.analytics.shifts', compact('businesses', 'locations', 'chartData', 'summaryData'));
    }

    public function transactions(Request $request)
    {
        // Get paginated transactions based on filters
        $transactions = ShiftTransaction::with(['shift.user', 'shift.location', 'shift.business', 'network'])
            ->when($request->filled('date_from'), function($query) use ($request) {
                return $query->whereDate('created_at', '>=', $request->date_from);
            })
            ->when($request->filled('date_to'), function($query) use ($request) {
                return $query->whereDate('created_at', '<=', $request->date_to);
            })
            ->when($request->filled('business_code'), function($query) use ($request) {
                return $query->whereHas('shift', function($q) use ($request) {
                    $q->where('business_code', $request->business_code);
                });
            })
            ->when($request->filled('type'), function($query) use ($request) {
                return $query->where('type', $request->type);
            })
            ->when($request->filled('location_id'), function($query) use ($request) {
                return $query->whereHas('shift', function($q) use ($request) {
                    $q->where('location_id', $request->location_id);
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Get summary data for cards
        $summaryData = $this->getTransactionsSummaryData($request);

        // Get chart data
        $chartData = $this->getTransactionsChartData($request);

        $businesses = Business::select('code', 'business_name as name')->get();
        $locations = Location::select('id', 'name')->get();

        return view('admin.analytics.transactions', compact(
            'transactions',
            'businesses',
            'locations',
            'summaryData',
            'chartData'
        ));
    }

    public function users(Request $request)
    {
        // Get paginated users based on filters
        $users = User::with(['business', 'locations'])
            ->when($request->filled('date_from'), function($query) use ($request) {
                return $query->whereDate('created_at', '>=', $request->date_from);
            })
            ->when($request->filled('date_to'), function($query) use ($request) {
                return $query->whereDate('created_at', '<=', $request->date_to);
            })
            ->when($request->filled('business_code'), function($query) use ($request) {
                return $query->where('business_code', $request->business_code);
            })
            ->when($request->filled('user_type'), function($query) use ($request) {
                return $query->where('type', $request->user_type);
            })
            ->when($request->filled('location_id'), function($query) use ($request) {
                return $query->whereHas('locations', function($q) use ($request) {
                    $q->where('locations.id', $request->location_id);
                });
            })
            ->withCount(['shifts as total_shifts'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Get summary data for cards
        $summaryData = $this->getUsersSummaryData($request);

        // Get chart data
        $chartData = $this->getUsersChartData($request);

        $businesses = Business::select('code', 'business_name as name')->get();
        $locations = Location::select('id', 'name')->get();

        return view('admin.analytics.users', compact(
            'users',
            'businesses',
            'locations',
            'summaryData',
            'chartData'
        ));
    }

    public function getShiftsData(Request $request)
    {
        try {
            $query = Shift::withoutGlobalScopes()
                ->with(['user', 'location', 'business'])
                ->select('shifts.*');

            // Apply date filters
            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }
            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            // Apply business filter
            if ($request->filled('business_code')) {
                $query->where('business_code', $request->business_code);
            }

            // Apply status filter
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            // Apply location filter
            if ($request->filled('location_id')) {
                $query->where('location_id', $request->location_id);
            }

            // Apply custom search filter
            if ($request->has('custom_search') && !empty($request->custom_search)) {
                $searchValue = $request->custom_search;
                $query->where(function($q) use ($searchValue) {
                    $q->where('id', 'like', '%' . $searchValue . '%')
                      ->orWhere('description', 'like', '%' . $searchValue . '%')
                      ->orWhereHas('user', function($subQ) use ($searchValue) {
                          $subQ->where('name', 'like', '%' . $searchValue . '%')
                               ->orWhere('email', 'like', '%' . $searchValue . '%');
                      })
                      ->orWhereHas('business', function($subQ) use ($searchValue) {
                          $subQ->where('business_name', 'like', '%' . $searchValue . '%');
                      })
                      ->orWhereHas('location', function($subQ) use ($searchValue) {
                          $subQ->where('name', 'like', '%' . $searchValue . '%');
                      });
                });
            }

            // Apply DataTables default search (fallback)
            if ($request->has('search') && !empty($request->search['value'])) {
                $searchValue = $request->search['value'];
                $query->where(function($q) use ($searchValue) {
                    $q->where('id', 'like', '%' . $searchValue . '%')
                      ->orWhere('description', 'like', '%' . $searchValue . '%')
                      ->orWhereHas('user', function($subQ) use ($searchValue) {
                          $subQ->where('name', 'like', '%' . $searchValue . '%');
                      });
                });
            }

            // Apply column ordering
            if ($request->has('order')) {
                $orderColumn = $request->order[0]['column'];
                $orderDirection = $request->order[0]['dir'];

                $columns = ['id', 'user_name', 'business_name', 'location_name', 'status', 'opening_balance', 'closing_balance', 'created_at'];
                if (isset($columns[$orderColumn])) {
                    switch ($columns[$orderColumn]) {
                        case 'user_name':
                            $query->join('users', 'shifts.user_code', '=', 'users.code')
                                  ->orderBy('users.name', $orderDirection);
                            break;
                        case 'business_name':
                            $query->join('businesses', 'shifts.business_code', '=', 'businesses.code')
                                  ->orderBy('businesses.business_name', $orderDirection);
                            break;
                        case 'location_name':
                            $query->join('locations', 'shifts.location_id', '=', 'locations.id')
                                  ->orderBy('locations.name', $orderDirection);
                            break;
                        default:
                            $query->orderBy($columns[$orderColumn], $orderDirection);
                            break;
                    }
                }
            } else {
                $query->orderBy('created_at', 'desc');
            }

            // Get total records (without filters except the form filters)
            $totalQuery = Shift::withoutGlobalScopes();
            if ($request->filled('date_from')) {
                $totalQuery->whereDate('created_at', '>=', $request->date_from);
            }
            if ($request->filled('date_to')) {
                $totalQuery->whereDate('created_at', '<=', $request->date_to);
            }
            if ($request->filled('business_code')) {
                $totalQuery->where('business_code', $request->business_code);
            }
            if ($request->filled('status')) {
                $totalQuery->where('status', $request->status);
            }
            if ($request->filled('location_id')) {
                $totalQuery->where('location_id', $request->location_id);
            }
            $totalRecords = $totalQuery->count();

            // Get filtered records count (before pagination)
            $filteredRecords = $query->count();

            // Apply pagination
            if ($request->has('start') && $request->has('length') && $request->length != -1) {
                $query->skip($request->start)->take($request->length);
            }

            $shifts = $query->get();

            $data = [];
            foreach ($shifts as $shift) {
                $statusClass = match($shift->status) {
                    ShiftStatusEnum::OPEN => 'badge-success',
                    ShiftStatusEnum::CLOSED => 'badge-secondary',
                    default => 'badge-warning'
                };

                $data[] = [
                    'id' => $shift->id,
                    'user_name' => $shift->user ? $shift->user->name : 'N/A',
                    'business_name' => $shift->business ? $shift->business->business_name : 'N/A',
                    'location_name' => $shift->location ? $shift->location->name : 'N/A',
                    'status' => '<span class="badge ' . $statusClass . '">' . ucfirst($shift->status->value) . '</span>',
                    'opening_balance' => number_format($shift->opening_balance ?? 0, 2),
                    'closing_balance' => number_format($shift->closing_balance ?? 0, 2),
                    'created_at' => $shift->created_at->format('Y-m-d H:i:s'),
                    'actions' => '<a href="' . route('admin.analytics.shifts.view', $shift->id) . '" class="btn btn-sm btn-primary">View Details</a>'
                ];
            }

            return response()->json([
                'draw' => intval($request->draw),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'draw' => intval($request->draw),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => 'Failed to load shifts: ' . $e->getMessage()
            ]);
        }
    }

    public function showShiftDetails($id)
    {
        try {
            $shift = Shift::withoutGlobalScopes()
                ->with(['user', 'location', 'business', 'transactions', 'loans', 'networks'])
                ->findOrFail($id);

            // Calculate shift statistics
            $totalTransactions = $shift->transactions()->count();
            $totalAmount = $shift->transactions()->sum('amount') ?: 0;
            $totalFee = $shift->transactions()->sum('fee') ?: 0;
            $totalLoans = $shift->loans()->count();
            $totalLoanAmount = $shift->loans()->sum('amount') ?: 0;

            // Get transaction breakdown by type
            $transactionBreakdown = $shift->transactions()
                ->selectRaw('type, COUNT(*) as count, SUM(amount) as total_amount')
                ->groupBy('type')
                ->get();

            // Get network balances
            $networkBalances = $shift->networks()
                ->select('networks.name', 'shift_networks.balance_old', 'shift_networks.balance_new')
                ->get();

            $statistics = [
                'total_transactions' => $totalTransactions,
                'total_amount' => $totalAmount,
                'total_fee' => $totalFee,
                'total_loans' => $totalLoans,
                'total_loan_amount' => $totalLoanAmount,
            ];

            return view('admin.analytics.shift-details', compact(
                'shift',
                'statistics',
                'transactionBreakdown',
                'networkBalances'
            ));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load shift details: ' . $e->getMessage());
        }
    }    public function getShiftTransactionsData(Request $request, $shiftId)
    {
        try {
            $shift = Shift::withoutGlobalScopes()->findOrFail($shiftId);

            $query = $shift->transactions()
                ->with(['user'])
                ->select('shift_transactions.*');

            // Apply custom search filter
            if ($request->has('custom_search') && !empty($request->custom_search)) {
                $searchValue = $request->custom_search;
                $query->where(function($q) use ($searchValue) {
                    $q->where('id', 'like', '%' . $searchValue . '%')
                      ->orWhere('description', 'like', '%' . $searchValue . '%')
                      ->orWhere('amount', 'like', '%' . $searchValue . '%')
                      ->orWhere('type', 'like', '%' . $searchValue . '%');
                });
            }

            // Apply type filter
            if ($request->has('type_filter') && !empty($request->type_filter)) {
                $query->where('type', $request->type_filter);
            }

            // Apply DataTables default search (fallback)
            if ($request->has('search') && !empty($request->search['value'])) {
                $searchValue = $request->search['value'];
                $query->where(function($q) use ($searchValue) {
                    $q->where('id', 'like', '%' . $searchValue . '%')
                      ->orWhere('description', 'like', '%' . $searchValue . '%')
                      ->orWhere('amount', 'like', '%' . $searchValue . '%')
                      ->orWhere('type', 'like', '%' . $searchValue . '%');
                });
            }

            // Apply column ordering
            if ($request->has('order')) {
                $orderColumn = $request->order[0]['column'];
                $orderDirection = $request->order[0]['dir'];

                $columns = ['id', 'type', 'amount', 'fee', 'description', 'created_at'];
                if (isset($columns[$orderColumn])) {
                    $query->orderBy($columns[$orderColumn], $orderDirection);
                }
            } else {
                $query->orderBy('created_at', 'desc');
            }

            // Get total records (without filters)
            $totalRecords = $shift->transactions()->count();

            // Get filtered records count (before pagination)
            $filteredRecords = $query->count();

            // Apply pagination
            if ($request->has('start') && $request->has('length') && $request->length != -1) {
                $query->skip($request->start)->take($request->length);
            }

            $transactions = $query->get();

            $data = [];
            foreach ($transactions as $transaction) {
                $typeClass = $transaction->type == \App\Utils\Enums\TransactionTypeEnum::MONEY_IN ? 'badge-success' : 'badge-danger';

                $data[] = [
                    'id' => $transaction->id,
                    'type' => '<span class="badge ' . $typeClass . '">' . $transaction->type->value . '</span>',
                    'amount' => number_format($transaction->amount, 2),
                    'fee' => number_format($transaction->fee ?? 0, 2),
                    'description' => $transaction->description ?? 'N/A',
                    'created_at' => $transaction->created_at->format('Y-m-d H:i:s'),
                ];
            }

            return response()->json([
                'draw' => intval($request->draw),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'draw' => intval($request->draw),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => 'Failed to load transactions: ' . $e->getMessage()
            ]);
        }
    }

    private function getSystemAnalyticsData($request)
    {
        $dateRange = $this->getDateRange($request);

        // System-wide statistics
        $totalBusinesses = Business::count();
        $verifiedBusinesses = Business::where('is_verified', true)->count();
        $totalUsers = User::where('type', UserTypeEnum::AGENT)->count();
        $activeUsers = User::where('type', UserTypeEnum::AGENT)
            ->whereHas('shifts', function($query) use ($dateRange) {
                $query->whereBetween('created_at', $dateRange);
            })
            ->count();

        $totalShifts = Shift::whereBetween('created_at', $dateRange)->count();
        $openShifts = Shift::where('status', ShiftStatusEnum::OPEN)->count();
        $closedShifts = Shift::where('status', ShiftStatusEnum::CLOSED)
            ->whereBetween('created_at', $dateRange)
            ->count();

        $totalTransactions = ShiftTransaction::whereBetween('created_at', $dateRange)->count();
        $totalAmount = ShiftTransaction::whereBetween('created_at', $dateRange)->sum('amount');
        $moneyIn = ShiftTransaction::where('type', TransactionTypeEnum::MONEY_IN)
            ->whereBetween('created_at', $dateRange)
            ->sum('amount');
        $moneyOut = ShiftTransaction::where('type', TransactionTypeEnum::MONEY_OUT)
            ->whereBetween('created_at', $dateRange)
            ->sum('amount');

        // Chart data
        $dailyStats = $this->getDailyStats($dateRange);
        $countryDistribution = $this->getCountryDistribution();
        $topBusinesses = $this->getTopBusinesses($dateRange);
        $recentActivities = $this->getRecentActivities();

        return [
            'totalBusinesses' => $totalBusinesses,
            'verifiedBusinesses' => $verifiedBusinesses,
            'totalUsers' => $totalUsers,
            'activeUsers' => $activeUsers,
            'totalShifts' => $totalShifts,
            'openShifts' => $openShifts,
            'closedShifts' => $closedShifts,
            'totalTransactions' => $totalTransactions,
            'totalAmount' => $totalAmount,
            'moneyIn' => $moneyIn,
            'moneyOut' => $moneyOut,
            'netAmount' => $moneyIn - $moneyOut,
            'dailyStats' => $dailyStats,
            'countryDistribution' => $countryDistribution,
            'topBusinesses' => $topBusinesses,
            'recentActivities' => $recentActivities,
            'dateRange' => $dateRange
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

    private function getDailyStats($dateRange)
    {
        $shifts = Shift::whereBetween('created_at', $dateRange)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $transactions = ShiftTransaction::whereBetween('created_at', $dateRange)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(amount) as total_amount')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $businesses = Business::whereBetween('created_at', $dateRange)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'dates' => $shifts->pluck('date'),
            'shifts' => $shifts->pluck('count'),
            'transactions' => $transactions->pluck('count'),
            'transaction_amounts' => $transactions->pluck('total_amount'),
            'businesses' => $businesses->pluck('count')
        ];
    }

    private function getCountryDistribution()
    {
        return Business::select('country_code', DB::raw('COUNT(*) as count'))
            ->groupBy('country_code')
            ->with('country')
            ->get()
            ->map(function($item) {
                return [
                    'country' => $item->country ? $item->country->name : $item->country_code,
                    'count' => $item->count
                ];
            });
    }

    private function getTopBusinesses($dateRange)
    {
        return Business::withCount(['shifts' => function($query) use ($dateRange) {
                $query->whereBetween('created_at', $dateRange);
            }])
            ->withSum(['business_account_transactions' => function($query) use ($dateRange) {
                $query->whereBetween('created_at', $dateRange);
            }], 'amount')
            ->orderByDesc('shifts_count')
            ->take(10)
            ->get();
    }

    private function getRecentActivities()
    {
        $recentShifts = Shift::with(['user', 'business'])
            ->latest()
            ->take(10)
            ->get();

        $recentTransactions = ShiftTransaction::with(['user', 'business'])
            ->latest()
            ->take(10)
            ->get();

        return [
            'shifts' => $recentShifts,
            'transactions' => $recentTransactions
        ];
    }

    private function getUserAnalytics($dateRange, $request)
    {
        return User::where('type', UserTypeEnum::AGENT)
            ->with(['business', 'shifts' => function($query) use ($dateRange) {
                $query->whereBetween('created_at', $dateRange);
            }])
            ->withCount(['shifts' => function($query) use ($dateRange) {
                $query->whereBetween('created_at', $dateRange);
            }])
            ->withSum(['shift_transactions' => function($query) use ($dateRange) {
                $query->whereBetween('created_at', $dateRange);
            }], 'amount')
            ->when($request->filled('business_code'), function($query) use ($request) {
                return $query->where('business_code', $request->business_code);
            })
            ->orderByDesc('shifts_count')
            ->take(50)
            ->get();
    }

    private function getBusinessPerformance($dateRange)
    {
        return Business::withCount(['shifts' => function($query) use ($dateRange) {
                $query->whereBetween('created_at', $dateRange);
            }])
            ->withSum(['business_account_transactions' => function($query) use ($dateRange) {
                $query->whereBetween('created_at', $dateRange);
            }], 'amount')
            ->orderByDesc('shifts_count')
            ->take(20)
            ->get();
    }

    private function getShiftsChartData(Request $request)
    {
        $dateRange = [
            Carbon::parse($request->date_from ?? now()->subDays(30)),
            Carbon::parse($request->date_to ?? now())
        ];

        // Status distribution
        $statusData = Shift::withoutGlobalScopes()
            ->whereBetween('created_at', $dateRange)
            ->when($request->filled('business_code'), function($query) use ($request) {
                return $query->where('business_code', $request->business_code);
            })
            ->when($request->filled('location_id'), function($query) use ($request) {
                return $query->where('location_id', $request->location_id);
            })
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // Business distribution
        $businessData = Shift::withoutGlobalScopes()
            ->with('business')
            ->whereBetween('created_at', $dateRange)
            ->when($request->filled('business_code'), function($query) use ($request) {
                return $query->where('business_code', $request->business_code);
            })
            ->when($request->filled('location_id'), function($query) use ($request) {
                return $query->where('location_id', $request->location_id);
            })
            ->select('business_code', DB::raw('count(*) as count'))
            ->groupBy('business_code')
            ->get();

        return [
            'statusChart' => [
                'labels' => $statusData->pluck('status')->toArray(),
                'data' => $statusData->pluck('count')->toArray()
            ],
            'businessChart' => [
                'labels' => $businessData->map(function($item) {
                    return $item->business ? $item->business->business_name : 'Unknown';
                })->toArray(),
                'data' => $businessData->pluck('count')->toArray()
            ]
        ];
    }

    private function getTransactionsChartData(Request $request)
    {
        $dateRange = [
            Carbon::parse($request->date_from ?? now()->subDays(30)),
            Carbon::parse($request->date_to ?? now())
        ];

        // Transaction types
        $typesData = ShiftTransaction::whereBetween('created_at', $dateRange)
            ->when($request->filled('business_code'), function($query) use ($request) {
                return $query->whereHas('shift', function($q) use ($request) {
                    $q->where('business_code', $request->business_code);
                });
            })
            ->when($request->filled('type'), function($query) use ($request) {
                return $query->where('type', $request->type);
            })
            ->when($request->filled('location_id'), function($query) use ($request) {
                return $query->whereHas('shift', function($q) use ($request) {
                    $q->where('location_id', $request->location_id);
                });
            })
            ->select('type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->get();

        // Daily volume
        $dailyData = ShiftTransaction::whereBetween('created_at', $dateRange)
            ->when($request->filled('business_code'), function($query) use ($request) {
                return $query->whereHas('shift', function($q) use ($request) {
                    $q->where('business_code', $request->business_code);
                });
            })
            ->when($request->filled('type'), function($query) use ($request) {
                return $query->where('type', $request->type);
            })
            ->when($request->filled('location_id'), function($query) use ($request) {
                return $query->whereHas('shift', function($q) use ($request) {
                    $q->where('location_id', $request->location_id);
                });
            })
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('sum(amount) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'typesChart' => [
                'labels' => $typesData->pluck('type')->toArray(),
                'data' => $typesData->pluck('count')->toArray()
            ],
            'dailyChart' => [
                'labels' => $dailyData->pluck('date')->toArray(),
                'data' => $dailyData->pluck('total')->toArray()
            ]
        ];
    }

    private function getTransactionsSummaryData(Request $request)
    {
        $dateRange = [
            Carbon::parse($request->date_from ?? now()->subDays(30)),
            Carbon::parse($request->date_to ?? now())
        ];

        $query = ShiftTransaction::whereBetween('created_at', $dateRange)
            ->when($request->filled('business_code'), function($query) use ($request) {
                return $query->whereHas('shift', function($q) use ($request) {
                    $q->where('business_code', $request->business_code);
                });
            })
            ->when($request->filled('type'), function($query) use ($request) {
                return $query->where('type', $request->type);
            })
            ->when($request->filled('location_id'), function($query) use ($request) {
                return $query->whereHas('shift', function($q) use ($request) {
                    $q->where('location_id', $request->location_id);
                });
            });

        $totalTransactions = $query->count();
        $totalAmount = $query->sum('amount');
        $cashInAmount = $query->where('type', TransactionTypeEnum::MONEY_IN)->sum('amount');
        $cashOutAmount = $query->where('type', TransactionTypeEnum::MONEY_OUT)->sum('amount');

        return [
            'total_transactions' => $totalTransactions,
            'total_amount' => number_format($totalAmount, 2),
            'cash_in_amount' => number_format($cashInAmount, 2),
            'cash_out_amount' => number_format($cashOutAmount, 2)
        ];
    }

    private function getUsersChartData(Request $request)
    {
        $dateRange = [
            Carbon::parse($request->date_from ?? now()->subDays(30)),
            Carbon::parse($request->date_to ?? now())
        ];

        // User types
        $typesData = User::whereBetween('created_at', $dateRange)
            ->when($request->filled('business_code'), function($query) use ($request) {
                return $query->where('business_code', $request->business_code);
            })
            ->when($request->filled('user_type'), function($query) use ($request) {
                return $query->where('type', $request->user_type);
            })
            ->when($request->filled('location_id'), function($query) use ($request) {
                return $query->whereHas('locations', function($q) use ($request) {
                    $q->where('locations.id', $request->location_id);
                });
            })
            ->select('type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->get();

        // Location distribution - using locations relationship
        $locationData = DB::table('location_users')
            ->join('locations', 'location_users.location_code', '=', 'locations.code')
            ->join('users', 'location_users.user_code', '=', 'users.code')
            ->whereBetween('users.created_at', $dateRange)
            ->when($request->filled('business_code'), function($query) use ($request) {
                return $query->where('users.business_code', $request->business_code);
            })
            ->when($request->filled('user_type'), function($query) use ($request) {
                return $query->where('users.type', $request->user_type);
            })
            ->select('locations.name as location_name', DB::raw('count(DISTINCT users.id) as count'))
            ->groupBy('locations.id', 'locations.name')
            ->get();

        return [
            'typesChart' => [
                'labels' => $typesData->pluck('type')->toArray(),
                'data' => $typesData->pluck('count')->toArray()
            ],
            'locationChart' => [
                'labels' => $locationData->pluck('location_name')->toArray(),
                'data' => $locationData->pluck('count')->toArray()
            ]
        ];
    }

    private function getUsersSummaryData(Request $request)
    {
        $dateRange = [
            Carbon::parse($request->date_from ?? now()->subDays(30)),
            Carbon::parse($request->date_to ?? now())
        ];

        $query = User::whereBetween('created_at', $dateRange)
            ->when($request->filled('business_code'), function($query) use ($request) {
                return $query->where('business_code', $request->business_code);
            })
            ->when($request->filled('user_type'), function($query) use ($request) {
                return $query->where('type', $request->user_type);
            })
            ->when($request->filled('location_id'), function($query) use ($request) {
                return $query->whereHas('locations', function($q) use ($request) {
                    $q->where('locations.id', $request->location_id);
                });
            });

        $totalUsers = $query->count();
        $activeUsers = $query->where('status', UserStatusEnum::ACTIVE)->count();
        $totalShifts = Shift::whereHas('user', function($q) use ($request, $dateRange) {
            $q->whereBetween('created_at', $dateRange);
            if ($request->filled('business_code')) {
                $q->where('business_code', $request->business_code);
            }
        })->count();
        $totalTransactions = ShiftTransaction::whereHas('shift.user', function($q) use ($request, $dateRange) {
            $q->whereBetween('created_at', $dateRange);
            if ($request->filled('business_code')) {
                $q->where('business_code', $request->business_code);
            }
        })->count();

        return [
            'total_users' => $totalUsers,
            'active_users' => $activeUsers,
            'total_shifts' => $totalShifts,
            'total_transactions' => $totalTransactions
        ];
    }

    private function getShiftsSummaryData(Request $request)
    {
        $dateRange = [
            Carbon::parse($request->date_from ?? now()->subDays(30)),
            Carbon::parse($request->date_to ?? now())
        ];

        $query = Shift::withoutGlobalScopes()
            ->whereBetween('created_at', $dateRange)
            ->when($request->filled('business_code'), function($query) use ($request) {
                return $query->where('business_code', $request->business_code);
            })
            ->when($request->filled('status'), function($query) use ($request) {
                return $query->where('status', $request->status);
            })
            ->when($request->filled('location_id'), function($query) use ($request) {
                return $query->where('location_id', $request->location_id);
            });

        $totalShifts = $query->count();
        $openShifts = $query->where('status', ShiftStatusEnum::OPEN)->count();
        $closedShifts = $query->where('status', ShiftStatusEnum::CLOSED)->count();
        $totalTransactions = ShiftTransaction::whereHas('shift', function($q) use ($dateRange, $request) {
            $q->whereBetween('created_at', $dateRange);
            if ($request->filled('business_code')) {
                $q->where('business_code', $request->business_code);
            }
            if ($request->filled('location_id')) {
                $q->where('location_id', $request->location_id);
            }
        })->count();

        return [
            'total_shifts' => $totalShifts,
            'open_shifts' => $openShifts,
            'closed_shifts' => $closedShifts,
            'total_transactions' => $totalTransactions
        ];
    }
}
