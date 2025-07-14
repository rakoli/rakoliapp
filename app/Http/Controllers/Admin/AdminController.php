<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Business;
use App\Models\ReferralPayment;
use App\Notifications\PaymentProcessed;
use App\Utils\StatisticsService;
use App\Utils\DataTableColumn;
use App\Utils\DataTableBuilder;
use App\Traits\DataTableable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{
    use DataTableable;
    public function referrals(Request $request)
    {
        $dataTable = new DataTables();
        $builder = $dataTable->getHtmlBuilder();
        $orderBy = null;
        $orderByFilter = null;

        if ($request->get('order_by')) {
            $orderBy = ['order_by' => $request->get('order_by')];
            $orderByFilter = $request->get('order_by');
        }

        $referrals = User::where('type', 'sales')
            ->with(['business.package', 'referredUsers.business.package'])
            ->orderBy('id', 'desc');

        if (request()->ajax()) {
            return \Yajra\DataTables\Facades\DataTables::eloquent($referrals)
                ->addColumn('actions', function (User $user) {
                    $content = '<a class="btn btn-primary btn-sm me-2" href="' . route('admin.referrals.view', $user->id) . '">' . __("View Referrals") . '</a>';

                    // Calculate actual pending amount including all bonuses
                    $referredUsers = User::where('referral_business_code', $user->business_code)
                        ->with('business.package')
                        ->get();

                    $totalEarnings = 0;
                    foreach ($referredUsers as $referredUser) {
                        if ($referredUser->business) {
                            $totalEarnings += 500;
                        }
                        if ($referredUser->business && $referredUser->business->package) {
                            $totalEarnings += $referredUser->business->package->price_commission ?? 0;
                        }

                        // Week 1 transaction bonus
                        if (method_exists($referredUser, 'getFirstWeekTransactionsCount')) {
                            $week1Count = $referredUser->getFirstWeekTransactionsCount();
                            if ($week1Count >= 10) {
                                $totalEarnings += 1000;
                            }
                        }

                        // Week 2 transaction bonus
                        if (method_exists($referredUser, 'getSecondWeekTransactionsCount')) {
                            $week2Count = $referredUser->getSecondWeekTransactionsCount();
                            if ($week2Count >= 10) {
                                $totalEarnings += 1000;
                            }
                        }
                    }

                    $paidAmount = ReferralPayment::where('user_id', $user->id)
                        ->where('payment_status', 'paid')
                        ->sum('amount');

                    $pendingAmount = max($totalEarnings - $paidAmount, 0);

                    if ($pendingAmount > 0) {
                        $content .= '<button class="btn btn-success btn-sm me-2" onclick="showPaymentModal(' . $user->id . ', \'' . $user->fname . ' ' . $user->lname . '\', ' . $pendingAmount . ')" title="Pay TZS ' . number_format($pendingAmount, 0) . '">' . __("Pay Now") . '</button>';
                    }

                    return $content;
                })                ->addColumn('total_earnings', function (User $user) {
                    // Calculate actual earnings based on referrals (not just ReferralPayment table)
                    $referredUsers = User::where('referral_business_code', $user->business_code)
                        ->with('business.package')
                        ->get();

                    $totalEarnings = 0;
                    foreach ($referredUsers as $referredUser) {
                        // Registration bonus for users with businesses
                        if ($referredUser->business) {
                            $totalEarnings += 500;
                        }

                        // Commission for users with packages
                        if ($referredUser->business && $referredUser->business->package) {
                            $totalEarnings += $referredUser->business->package->price_commission ?? 0;
                        }

                        // Week 1 transaction bonus (if user has 10+ transactions in first week)
                        if (method_exists($referredUser, 'getFirstWeekTransactionsCount')) {
                            $week1Count = $referredUser->getFirstWeekTransactionsCount();
                            if ($week1Count >= 10) {
                                $totalEarnings += 1000;
                            }
                        }

                        // Week 2 transaction bonus (if user has 10+ transactions in second week)
                        if (method_exists($referredUser, 'getSecondWeekTransactionsCount')) {
                            $week2Count = $referredUser->getSecondWeekTransactionsCount();
                            if ($week2Count >= 10) {
                                $totalEarnings += 1000;
                            }
                        }
                    }

                    // Get earnings from payment table
                    $paymentEarnings = ReferralPayment::where('user_id', $user->id)->sum('amount');

                    // Use the higher value (calculated vs recorded payments)
                    $actualEarnings = max($totalEarnings, $paymentEarnings);

                    return session('currency', 'TZS') . ' ' . number_format($actualEarnings, 0);
                })                ->addColumn('pending_payments', function (User $user) {
                    // Calculate what should be pending based on actual earnings
                    $referredUsers = User::where('referral_business_code', $user->business_code)
                        ->with('business.package')
                        ->get();

                    $totalEarnings = 0;
                    foreach ($referredUsers as $referredUser) {
                        if ($referredUser->business) {
                            $totalEarnings += 500;
                        }
                        if ($referredUser->business && $referredUser->business->package) {
                            $totalEarnings += $referredUser->business->package->price_commission ?? 0;
                        }

                        // Week 1 transaction bonus
                        if (method_exists($referredUser, 'getFirstWeekTransactionsCount')) {
                            $week1Count = $referredUser->getFirstWeekTransactionsCount();
                            if ($week1Count >= 10) {
                                $totalEarnings += 1000;
                            }
                        }

                        // Week 2 transaction bonus
                        if (method_exists($referredUser, 'getSecondWeekTransactionsCount')) {
                            $week2Count = $referredUser->getSecondWeekTransactionsCount();
                            if ($week2Count >= 10) {
                                $totalEarnings += 1000;
                            }
                        }
                    }

                    $paidAmount = ReferralPayment::where('user_id', $user->id)
                        ->where('payment_status', 'paid')
                        ->sum('amount');

                    $pendingFromTable = ReferralPayment::where('user_id', $user->id)
                        ->where('payment_status', 'pending')
                        ->sum('amount');

                    // Pending amount is either what's in the table or the difference between earned and paid
                    $pendingAmount = max($totalEarnings - $paidAmount, $pendingFromTable);

                    $class = $pendingAmount > 0 ? 'text-danger fw-bold' : 'text-muted';
                    return '<span class="' . $class . '">' . session('currency', 'TZS') . ' ' . number_format($pendingAmount, 0) . '</span>';
                })                ->addColumn('payment_status', function (User $user) {
                    // Calculate actual earnings including all bonuses
                    $referredUsers = User::where('referral_business_code', $user->business_code)
                        ->with('business.package')
                        ->get();

                    $totalEarnings = 0;
                    foreach ($referredUsers as $referredUser) {
                        if ($referredUser->business) {
                            $totalEarnings += 500;
                        }
                        if ($referredUser->business && $referredUser->business->package) {
                            $totalEarnings += $referredUser->business->package->price_commission ?? 0;
                        }

                        // Week 1 transaction bonus
                        if (method_exists($referredUser, 'getFirstWeekTransactionsCount')) {
                            $week1Count = $referredUser->getFirstWeekTransactionsCount();
                            if ($week1Count >= 10) {
                                $totalEarnings += 1000;
                            }
                        }

                        // Week 2 transaction bonus
                        if (method_exists($referredUser, 'getSecondWeekTransactionsCount')) {
                            $week2Count = $referredUser->getSecondWeekTransactionsCount();
                            if ($week2Count >= 10) {
                                $totalEarnings += 1000;
                            }
                        }
                    }

                    $paidAmount = ReferralPayment::where('user_id', $user->id)
                        ->where('payment_status', 'paid')
                        ->sum('amount');
                    $pendingAmount = max($totalEarnings - $paidAmount, 0);

                    if ($totalEarnings == 0) {
                        return '<span class="badge badge-light-secondary">No Earnings</span>';
                    } elseif ($pendingAmount == 0) {
                        return '<span class="badge badge-light-success">Fully Paid</span>';
                    } elseif ($paidAmount == 0) {
                        return '<span class="badge badge-light-warning">Pending Payment</span>';
                    } else {
                        return '<span class="badge badge-light-info">Partially Paid</span>';
                    }
                })
                ->addColumn('name', function (User $user) {
                    return "$user->fname $user->lname";
                })
                ->addColumn('total_referrals', function (User $user) {
                    // Get fresh count of referred users for this sales user
                    $count = User::where('referral_business_code', $user->business_code)->count();
                    return $count;
                })
                ->addColumn('active_referrals', function (User $user) {
                    // Get fresh count of active referrals (users with businesses and packages)
                    $count = User::where('referral_business_code', $user->business_code)
                        ->whereHas('business', function($q) {
                            $q->whereNotNull('package_code');
                        })
                        ->count();
                    return $count;
                })
                ->addColumn('total_commission', function (User $user) {
                    // Get fresh commission calculation
                    $totalCommission = User::where('referral_business_code', $user->business_code)
                        ->whereHas('business.package')
                        ->with('business.package')
                        ->get()
                        ->sum(function($referredUser) {
                            return $referredUser->business->package->price_commission ?? 0;
                        });
                    return session('currency', 'TZS') . ' ' . number_format($totalCommission, 2);
                })
                ->addColumn('business_name', function (User $user) {
                    $business = $user->business;
                    if($business == null){
                        return '<span class="text-muted">Not Registered</span>';
                    }
                    return $business->business_name;
                })
                ->filterColumn('name', function($query, $keyword) {
                    $query->where(function($q) use ($keyword) {
                        $q->where('fname', 'like', "%{$keyword}%")
                          ->orWhere('lname', 'like', "%{$keyword}%")
                          ->orWhereRaw("CONCAT(fname, ' ', lname) like ?", ["%{$keyword}%"]);
                    });
                })
                ->filterColumn('email', function($query, $keyword) {
                    $query->where('email', 'like', "%{$keyword}%");
                })
                ->filterColumn('phone', function($query, $keyword) {
                    $query->where('phone', 'like', "%{$keyword}%");
                })
                ->filterColumn('business_name', function($query, $keyword) {
                    $query->whereHas('business', function($q) use ($keyword) {
                        $q->where('business_name', 'like', "%{$keyword}%");
                    });
                })
                ->rawColumns(['actions', 'registration_status', 'package_status', 'business_name', 'pending_payments', 'payment_status'])
                ->addIndexColumn()
                ->make(true);
        }

        $dataTableHtml = $this->createDataTableBuilder()
            ->columns([
                $this->createIdColumn(),
                $this->createNameColumn('name', __('Sales User Name')),
                $this->createEmailColumn(),
                $this->createPhoneColumn(),
                DataTableColumn::make('business_name')
                    ->title(__('Business Name'))
                    ->searchable(),
                DataTableColumn::make('total_referrals')
                    ->title(__('Total Referrals'))
                    ->centerAlign()
                    ->width('120px'),
                DataTableColumn::make('active_referrals')
                    ->title(__('Active Referrals'))
                    ->centerAlign()
                    ->width('120px'),
                $this->createAmountColumn('total_commission', __('Total Commission'))
                    ->width('140px'),
                DataTableColumn::make('total_earnings')
                    ->title(__('Total Earnings'))
                    ->centerAlign()
                    ->width('120px'),
                DataTableColumn::make('pending_payments')
                    ->title(__('Pending'))
                    ->centerAlign()
                    ->width('100px'),
                DataTableColumn::make('payment_status')
                    ->title(__('Payment Status'))
                    ->centerAlign()
                    ->width('120px'),
                $this->createActionsColumn()
                    ->width('250px'),
            ])
            ->responsive(true)
            ->ordering(false)
            ->searching(true)
            ->ajax(route('admin.referrals.index', $orderBy))
            ->paging(true)
            ->dom('frtilp')
            ->lengthMenu([[25, 50, 100, -1], [25, 50, 100, "All"]])
            ->build();        // Get fresh data for accurate stats calculation using same approach as viewSalesUserReferrals
        $salesUsers = User::where('type', 'sales')->get();

        $stats = [
            'total_sales_users' => $salesUsers->count(),
            'total_referrals' => $salesUsers->sum(function($salesUser) {
                return User::where('referral_business_code', $salesUser->business_code)->count();
            }),
            'active_referrals' => $salesUsers->sum(function($salesUser) {
                return User::where('referral_business_code', $salesUser->business_code)
                    ->whereHas('business', function($q) {
                        $q->whereNotNull('package_code');
                    })
                    ->count();
            }),
            'total_commission' => $salesUsers->sum(function($salesUser) {
                return User::where('referral_business_code', $salesUser->business_code)
                    ->whereHas('business.package')
                    ->with('business.package')
                    ->get()
                    ->sum(function($referredUser) {
                        return $referredUser->business->package->price_commission ?? 0;
                    });
            })
        ];        // Calculate earnings statistics - only for sales users' referrals
        $salesUsers = User::where('type', 'sales')->get();

        // Calculate actual earnings based on registrations and packages (not just ReferralPayment table)
        $registrationBonuses = 0;
        $commissionEarnings = 0;
        $week1Bonuses = 0;
        $week2Bonuses = 0;

        foreach ($salesUsers as $salesUser) {
            $referredUsers = User::where('referral_business_code', $salesUser->business_code)
                ->with(['business.package'])
                ->get();

            foreach ($referredUsers as $referredUser) {
                // Registration bonus for users with businesses
                if ($referredUser->business) {
                    $registrationBonuses += 500; // Standard registration bonus
                }

                // Commission earnings for users with packages
                if ($referredUser->business && $referredUser->business->package) {
                    $commissionEarnings += $referredUser->business->package->price_commission ?? 0;
                }

                // Week 1 transaction bonus (if user has 10+ transactions in first week)
                if (method_exists($referredUser, 'getFirstWeekTransactionsCount')) {
                    $week1Count = $referredUser->getFirstWeekTransactionsCount();
                    if ($week1Count >= 10) {
                        $week1Bonuses += 1000;
                    }
                }

                // Week 2 transaction bonus (if user has 10+ transactions in second week)
                if (method_exists($referredUser, 'getSecondWeekTransactionsCount')) {
                    $week2Count = $referredUser->getSecondWeekTransactionsCount();
                    if ($week2Count >= 10) {
                        $week2Bonuses += 1000;
                    }
                }
            }
        }

        $totalCalculatedEarnings = $registrationBonuses + $commissionEarnings + $week1Bonuses + $week2Bonuses;

        // Get payment statistics from ReferralPayment table - only for sales users
        $salesUserIds = User::where('type', 'sales')->pluck('id');
        $totalPaid = ReferralPayment::whereIn('user_id', $salesUserIds)->where('payment_status', 'paid')->sum('amount');
        $pendingPayments = ReferralPayment::whereIn('user_id', $salesUserIds)->where('payment_status', 'pending')->sum('amount');
        $totalEarnedFromPayments = ReferralPayment::whereIn('user_id', $salesUserIds)->sum('amount');

        // Use calculated earnings if higher than payment table (which means payments haven't been created yet)
        $actualTotalEarned = max($totalCalculatedEarnings, $totalEarnedFromPayments);

        $earningStats = [
            'total_earned' => $actualTotalEarned,
            'total_paid' => $totalPaid,
            'pending_payments' => max($actualTotalEarned - $totalPaid, $pendingPayments),
            'outstanding_balance' => $actualTotalEarned - $totalPaid,
            'registration_bonuses' => max($registrationBonuses, ReferralPayment::whereIn('user_id', $salesUserIds)->where('payment_type', 'registration_bonus')->sum('amount')),
            'transaction_bonuses' => max($week1Bonuses + $week2Bonuses, ReferralPayment::whereIn('user_id', $salesUserIds)->whereIn('payment_type', ['transaction_bonus_week1', 'transaction_bonus_week2'])->sum('amount')),
        ];

        return view('admin.referrals', compact('dataTableHtml', 'orderByFilter', 'stats', 'earningStats'));
    }

    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_businesses' => Business::count(),
            'total_referrals' => User::whereNotNull('referral_business_code')->count(),
            'active_referrals' => User::whereNotNull('referral_business_code')
                ->whereHas('business', function($q) {
                    $q->whereNotNull('package_code');
                })->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function viewSalesUserReferrals(Request $request, $userId)
    {
        $salesUser = User::where('type', 'sales')
            ->with(['business', 'referredUsers.business.package'])
            ->findOrFail($userId);

        $dataTable = new DataTables();
        $builder = $dataTable->getHtmlBuilder();
        $orderBy = null;
        $orderByFilter = null;

        if ($request->get('order_by')) {
            $orderBy = ['order_by' => $request->get('order_by')];
            $orderByFilter = $request->get('order_by');
        }

        $referredUsers = User::where('referral_business_code', $salesUser->business_code)
            ->with(['business.package'])
            ->orderBy('id', 'desc');

        if (request()->ajax()) {
            return \Yajra\DataTables\Facades\DataTables::eloquent($referredUsers)
                ->addColumn('actions', function (User $user) {
                    $content = '<a class="btn btn-secondary btn-sm me-2" href="' . route('admin.business.viewbusiness', $user->business_code ?? '') . '">' . __("View Business") . '</a>';
                    //$content .= '<a class="btn btn-secondary btn-sm me-2" href="' . route('admin.business.edituser', $user->id) . '">' . __("Edit") . '</a>';
                    return $content;
                })
                ->addColumn('name', function (User $user) {
                    return "$user->fname $user->lname";
                })
                ->addColumn('registration_status', function (User $user) {
                    $business = $user->business;
                    if($business == null){
                        return '<span class="badge badge-light-danger">Not Registered</span>';
                    }
                    $package = $business->package_code;
                    if($package == null){
                        return '<span class="badge badge-light-warning">No Active Package</span>';
                    }
                    return '<span class="badge badge-light-success">Complete</span>';
                })
                ->addColumn('package_status', function (User $user) {
                    $business = $user->business;
                    if($business == null){
                        return '<span class="badge badge-light-info">None</span>';
                    }
                    $package = $business->package_code;
                    if($package == null){
                        return '<span class="badge badge-light-info">None</span>';
                    }
                    $packageName = $user->business->package->name ?? 'Unknown';
                    return '<span class="badge badge-light-primary">' . ucfirst($packageName) . '</span>';
                })
                ->addColumn('business_name', function (User $user) {
                    $business = $user->business;
                    if($business == null){
                        return '<span class="text-muted">Not Registered</span>';
                    }
                    return $business->business_name;
                })
                ->addColumn('commission_value', function (User $user) {
                    $business = $user->business;
                    if($business == null){
                        return session('currency', 'TZS') . ' ' . number_format(0,2);
                    }
                    $package = $business->package_code;
                    if($package == null){
                        return session('currency', 'TZS') . ' ' . number_format(0,2);
                    }
                    $packageCommission = $user->business->package->price_commission ?? 0;
                    return session('currency', 'TZS') . ' ' . number_format($packageCommission,2);
                })
                ->addColumn('registration_bonus', function (User $user) {
                    $bonus = $user->isRegistrationCompleted() ? 500 : 0;
                    return session('currency', 'TZS') . ' ' . number_format($bonus, 0);
                })
                ->addColumn('week1_transactions', function (User $user) {
                    $count = $user->getFirstWeekTransactionsCount();
                    $bonus = $count >= 10 ? 1000 : 0;
                    return $count . ' (' . session('currency', 'TZS') . ' ' . number_format($bonus, 0) . ')';
                })
                ->addColumn('week2_transactions', function (User $user) {
                    $count = $user->getSecondWeekTransactionsCount();
                    $bonus = $count >= 10 ? 1000 : 0;
                    return $count . ' (' . session('currency', 'TZS') . ' ' . number_format($bonus, 0) . ')';
                })
                ->addColumn('bonus_status', function (User $user) {
                    $status = $user->getBonusStatus();
                    return '<span class="badge ' . $status['class'] . '">' . $status['label'] . '</span>';
                })
                ->addColumn('total_earnings', function (User $user) {
                    $earnings = $user->getTotalReferralEarnings();
                    return session('currency', 'TZS') . ' ' . number_format($earnings, 0);
                })
                ->addColumn('payment_status', function (User $user) {
                    $status = $user->getPaymentStatusAttribute();
                    return '<span class="badge ' . $status['class'] . '">' . $status['label'] . '</span>';
                })
                ->addColumn('amount_paid', function (User $user) {
                    $paid = $user->getTotalPaid();
                    $earned = $user->getTotalEarnings();
                    return session('currency', 'TZS') . ' ' . number_format($paid, 0) . ' / ' . number_format($earned, 0);
                })
                ->addColumn('outstanding_balance', function (User $user) {
                    $balance = $user->getRemainingBalance();
                    $class = $balance > 0 ? 'text-danger' : 'text-success';
                    return '<span class="' . $class . '">' . session('currency', 'TZS') . ' ' . number_format($balance, 0) . '</span>';
                })
                ->addColumn('last_payment', function (User $user) {
                    $lastPayment = $user->getLastPaymentDate();
                    return $lastPayment ? $lastPayment->format('Y-m-d') : '<span class="text-muted">Never</span>';
                })
                ->addColumn('payment_actions', function (User $user) {
                    $pending = $user->getPendingPayments();
                    if ($pending > 0) {
                        return '<button class="btn btn-sm btn-success" onclick="processPayment(' . $user->id . ')">' . __('Pay Now') . '</button>';
                    }
                    return '<span class="text-muted">No pending</span>';
                })
                ->addColumn('created_at', function (User $user) {
                    return $user->created_at->format('Y-m-d H:i:s');
                })
                ->filterColumn('phone', function($query, $keyword) {
                    $query->where('phone', 'like', "%{$keyword}%");
                })
                ->filterColumn('business_name', function($query, $keyword) {
                    $query->whereHas('business', function($q) use ($keyword) {
                        $q->where('business_name', 'like', "%{$keyword}%");
                    });
                })
                ->rawColumns(['actions', 'registration_status', 'package_status', 'business_name', 'bonus_status', 'payment_status', 'outstanding_balance', 'last_payment', 'payment_actions'])
                ->addIndexColumn()
                ->make(true);
        }

        $dataTableHtml = $this->createDataTableBuilder()
            ->columns([
                DataTableColumn::make('business_name')
                    ->title(__('Business Name'))
                    ->searchable()
                    ->width('150px'),
                $this->createPhoneColumn()->width('120px'),
                $this->createStatusColumn('registration_status', __('Reg Status'))
                    ->width('100px'),
                $this->createStatusColumn('package_status', __('Package Status'))
                    ->width('120px'),
                DataTableColumn::make('payment_status')
                    ->title(__('Payment Status'))
                    ->centerAlign()
                    ->width('120px'),
                DataTableColumn::make('amount_paid')
                    ->title(__('Paid/Earned'))
                    ->centerAlign()
                    ->width('120px'),
                DataTableColumn::make('outstanding_balance')
                    ->title(__('Outstanding'))
                    ->centerAlign()
                    ->width('100px'),
                DataTableColumn::make('last_payment')
                    ->title(__('Last Payment'))
                    ->centerAlign()
                    ->width('120px'),
                DataTableColumn::make('registration_bonus')
                    ->title(__('Reg Bonus'))
                    ->centerAlign()
                    ->width('100px'),
                DataTableColumn::make('week1_transactions')
                    ->title(__('Week 1'))
                    ->centerAlign()
                    ->width('100px'),
                DataTableColumn::make('week2_transactions')
                    ->title(__('Week 2'))
                    ->centerAlign()
                    ->width('100px'),
                DataTableColumn::make('bonus_status')
                    ->title(__('Status'))
                    ->centerAlign()
                    ->width('100px'),
                DataTableColumn::make('total_earnings')
                    ->title(__('Total'))
                    ->centerAlign()
                    ->width('100px'),
                DataTableColumn::make('payment_actions')
                    ->title(__('Actions'))
                    ->centerAlign()
                    ->width('100px'),
                $this->createDateColumn('created_at', __('Referred Date'))
                    ->width('120px'),
            ])
            ->responsive(true)
            ->ordering(false)
            ->searching(true)
            ->ajax(route('admin.referrals.view', [$userId, $orderBy]))
            ->paging(true)
            ->dom('frtilp')
            ->lengthMenu([[25, 50, 100, -1], [25, 50, 100, "All"]])
            ->build();

        // Get fresh data for accurate stats calculation
        $allReferredUsers = User::where('referral_business_code', $salesUser->business_code)
            ->with(['business.package'])
            ->get();

        $stats = [
            'total_referrals' => $allReferredUsers->count(),
            'active_referrals' => $allReferredUsers->filter(function($user) {
                return $user->business && $user->business->package_code;
            })->count(),
            'inactive_referrals' => $allReferredUsers->filter(function($user) {
                return !$user->business || !$user->business->package_code;
            })->count(),
            'total_commission' => $allReferredUsers->sum(function($user) {
                return $user->business && $user->business->package
                    ? $user->business->package->price_commission ?? 0
                    : 0;
            })
        ];

        return view('admin.referrals_detail', compact('dataTableHtml', 'orderByFilter', 'stats', 'salesUser'));
    }

    public function debugSearch(Request $request)
    {
        \Log::info('DataTable request:', $request->all());

        $referrals = User::where('type', 'sales')
            ->with(['business.package', 'referredUsers.business.package'])
            ->orderBy('id', 'desc');

        if (request()->ajax()) {
            return \Yajra\DataTables\Facades\DataTables::eloquent($referrals)
                ->addColumn('actions', function (User $user) {
                    return '<button class="btn btn-sm btn-primary">View</button>';
                })
                ->addColumn('name', function (User $user) {
                    return "$user->fname $user->lname";
                })
                ->addColumn('business_name', function (User $user) {
                    return $user->business ? $user->business->business_name : 'No Business';
                })
                ->filterColumn('name', function($query, $keyword) {
                    \Log::info('Searching name with keyword: ' . $keyword);
                    $query->where(function($q) use ($keyword) {
                        $q->where('fname', 'like', "%{$keyword}%")
                          ->orWhere('lname', 'like', "%{$keyword}%")
                          ->orWhereRaw("CONCAT(fname, ' ', lname) like ?", ["%{$keyword}%"]);
                    });
                })
                ->filterColumn('email', function($query, $keyword) {
                    \Log::info('Searching email with keyword: ' . $keyword);
                    $query->where('email', 'like', "%{$keyword}%");
                })
                ->filterColumn('phone', function($query, $keyword) {
                    \Log::info('Searching phone with keyword: ' . $keyword);
                    $query->where('phone', 'like', "%{$keyword}%");
                })
                ->filterColumn('business_name', function($query, $keyword) {
                    \Log::info('Searching business_name with keyword: ' . $keyword);
                    $query->whereHas('business', function($q) use ($keyword) {
                        $q->where('business_name', 'like', "%{$keyword}%");
                    });
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return response()->json(['error' => 'Not AJAX request']);
    }

    /**
     * Payment Management Methods
     */
    public function processPayment(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'payment_ids' => 'required|array',
            'payment_method' => 'required|string',
            'payment_reference' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        $user = User::findOrFail($request->user_id);
        $processedPayments = [];

        foreach ($request->payment_ids as $paymentId) {
            $payment = ReferralPayment::findOrFail($paymentId);

            if ($payment->payment_status === 'pending') {
                $payment->markAsPaid(
                    $request->payment_method,
                    $request->payment_reference,
                    auth()->id()
                );

                // Send notification to the sales user
                $payment->user->notify(new PaymentProcessed($payment));

                $processedPayments[] = $payment;
            }
        }

        return response()->json([
            'success' => true,
            'message' => count($processedPayments) . ' payment(s) processed successfully',
            'processed_count' => count($processedPayments)
        ]);
    }

    public function processBulkPayments(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'payment_method' => 'required|string',
            'payment_reference_prefix' => 'nullable|string'
        ]);

        $processedCount = 0;

        foreach ($request->user_ids as $userId) {
            $pendingPayments = ReferralPayment::where('user_id', $userId)
                ->where('payment_status', 'pending')
                ->get();

            foreach ($pendingPayments as $payment) {
                $reference = $request->payment_reference_prefix . '-' . $payment->id;
                $payment->markAsPaid(
                    $request->payment_method,
                    $reference,
                    auth()->id()
                );

                // Send notification to the sales user
                $payment->user->notify(new PaymentProcessed($payment));

                $processedCount++;
            }
        }

        return response()->json([
            'success' => true,
            'message' => $processedCount . ' payment(s) processed successfully',
            'processed_count' => $processedCount
        ]);
    }

    public function paymentHistory($userId)
    {
        $user = User::findOrFail($userId);
        $payments = $user->referralPayments()
            ->with(['referral', 'processedBy'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.partials.payment-history', compact('user', 'payments'));
    }

    public function updatePayment(Request $request, $paymentId)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,cancelled,partial',
            'payment_method' => 'nullable|string',
            'payment_reference' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        $payment = ReferralPayment::findOrFail($paymentId);

        $payment->update([
            'payment_status' => $request->payment_status,
            'payment_method' => $request->payment_method,
            'payment_reference' => $request->payment_reference,
            'notes' => $request->notes,
            'paid_at' => $request->payment_status === 'paid' ? now() : null,
            'processed_by' => auth()->id()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment updated successfully'
        ]);
    }

    public function exportPayments(Request $request)
    {
        $query = ReferralPayment::with(['user', 'referral', 'processedBy']);

        // Apply filters
        if ($request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->payment_type) {
            $query->where('payment_type', $request->payment_type);
        }

        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $payments = $query->get();

        $csvData = [];
        $csvData[] = [
            'Sales User', 'Referred Business', 'Payment Type', 'Amount',
            'Status', 'Payment Method', 'Reference', 'Earned Date',
            'Paid Date', 'Processed By'
        ];

        foreach ($payments as $payment) {
            $csvData[] = [
                $payment->user->name(),
                $payment->referral->business->business_name ?? 'N/A',
                ucfirst(str_replace('_', ' ', $payment->payment_type)),
                $payment->amount,
                ucfirst($payment->payment_status),
                $payment->payment_method ?? 'N/A',
                $payment->payment_reference ?? 'N/A',
                $payment->created_at->format('Y-m-d'),
                $payment->paid_at ? $payment->paid_at->format('Y-m-d') : 'N/A',
                $payment->processedBy->name() ?? 'N/A'
            ];
        }

        $filename = 'referral-payments-' . date('Y-m-d-H-i-s') . '.csv';

        return response()->streamDownload(function() use ($csvData) {
            $file = fopen('php://output', 'w');
            foreach ($csvData as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    /**
     * Process individual referral payment
     */
    public function processReferralPayment(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'payment_method' => 'required|string|max:50',
            'payment_reference' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:500'
        ]);

        try {
            $user = User::findOrFail($request->user_id);

            // Get existing pending payments
            $pendingPayments = ReferralPayment::where('user_id', $user->id)
                ->where('payment_status', 'pending')
                ->get();

            // If no pending payments exist, create them based on referrals
            if ($pendingPayments->isEmpty()) {
                $referredUsers = User::where('referral_business_code', $user->business_code)
                    ->with('business.package')
                    ->get();

                foreach ($referredUsers as $referredUser) {
                    // Create registration bonus payment
                    if ($referredUser->business) {
                        $existingRegBonus = ReferralPayment::where('user_id', $user->id)
                            ->where('referral_id', $referredUser->id)
                            ->where('payment_type', 'registration_bonus')
                            ->first();

                        if (!$existingRegBonus) {
                            ReferralPayment::create([
                                'user_id' => $user->id,
                                'referral_id' => $referredUser->id,
                                'amount' => 500,
                                'payment_type' => 'registration_bonus',
                                'payment_status' => 'pending',
                                'created_at' => $referredUser->created_at,
                                'updated_at' => now()
                            ]);
                        }
                    }

                    // Create package commission payment
                    if ($referredUser->business && $referredUser->business->package) {
                        $commission = $referredUser->business->package->price_commission ?? 0;
                        if ($commission > 0) {
                            $existingCommission = ReferralPayment::where('user_id', $user->id)
                                ->where('referral_id', $referredUser->id)
                                ->where('payment_type', 'package_commission')
                                ->first();

                            if (!$existingCommission) {
                                ReferralPayment::create([
                                    'user_id' => $user->id,
                                    'referral_id' => $referredUser->id,
                                    'amount' => $commission,
                                    'payment_type' => 'package_commission',
                                    'payment_status' => 'pending',
                                    'created_at' => $referredUser->created_at,
                                    'updated_at' => now()
                                ]);
                            }
                        }
                    }
                }

                // Refresh pending payments after creation
                $pendingPayments = ReferralPayment::where('user_id', $user->id)
                    ->where('payment_status', 'pending')
                    ->get();
            }

            if ($pendingPayments->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No pending payments found for this user'
                ], 400);
            }

            $processedCount = 0;
            $totalAmount = 0;

            foreach ($pendingPayments as $payment) {
                $payment->markAsPaid(
                    $request->payment_method,
                    $request->payment_reference . '-' . $payment->id,
                    auth()->id()
                );

                if ($request->notes) {
                    $payment->update(['notes' => $request->notes]);
                }

                // Send notification to the sales user
                $payment->user->notify(new PaymentProcessed($payment));

                $processedCount++;
                $totalAmount += $payment->amount;
            }

            return response()->json([
                'success' => true,
                'message' => "Successfully processed {$processedCount} payment(s) totaling TZS " . number_format($totalAmount, 0),
                'processed_count' => $processedCount,
                'total_amount' => $totalAmount
            ]);

        } catch (\Exception $e) {
            \Log::error('Payment processing failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Payment processing failed. Please try again.'
            ], 500);
        }
    }

    /**
     * Get pending payments for a user
     */
    public function getPendingPayments(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        // Get existing pending payments from the table
        $pendingPayments = ReferralPayment::where('user_id', $userId)
            ->where('payment_status', 'pending')
            ->with('referral')
            ->orderBy('created_at', 'desc')
            ->get();

        // If no pending payments exist, calculate what should be pending
        if ($pendingPayments->isEmpty()) {
            $referredUsers = User::where('referral_business_code', $user->business_code)
                ->with('business.package')
                ->get();

            $calculatedPayments = [];
            $totalPending = 0;

            foreach ($referredUsers as $referredUser) {
                // Registration bonus
                if ($referredUser->business) {
                    $calculatedPayments[] = [
                        'id' => 'calc_' . $referredUser->id . '_reg',
                        'amount' => 500,
                        'payment_type' => 'Registration Bonus',
                        'referral_name' => $referredUser->fname . ' ' . $referredUser->lname,
                        'created_at' => $referredUser->created_at->format('Y-m-d H:i:s')
                    ];
                    $totalPending += 500;
                }

                // Package commission
                if ($referredUser->business && $referredUser->business->package) {
                    $commission = $referredUser->business->package->price_commission ?? 0;
                    if ($commission > 0) {
                        $calculatedPayments[] = [
                            'id' => 'calc_' . $referredUser->id . '_comm',
                            'amount' => $commission,
                            'payment_type' => 'Package Commission',
                            'referral_name' => $referredUser->fname . ' ' . $referredUser->lname,
                            'created_at' => $referredUser->created_at->format('Y-m-d H:i:s')
                        ];
                        $totalPending += $commission;
                    }
                }

                // Week 1 transaction bonus
                if (method_exists($referredUser, 'getFirstWeekTransactionsCount')) {
                    $week1Count = $referredUser->getFirstWeekTransactionsCount();
                    if ($week1Count >= 10) {
                        $calculatedPayments[] = [
                            'id' => 'calc_' . $referredUser->id . '_week1',
                            'amount' => 1000,
                            'payment_type' => 'Week 1 Transaction Bonus',
                            'referral_name' => $referredUser->fname . ' ' . $referredUser->lname,
                            'created_at' => $referredUser->created_at->addWeek()->format('Y-m-d H:i:s')
                        ];
                        $totalPending += 1000;
                    }
                }

                // Week 2 transaction bonus
                if (method_exists($referredUser, 'getSecondWeekTransactionsCount')) {
                    $week2Count = $referredUser->getSecondWeekTransactionsCount();
                    if ($week2Count >= 10) {
                        $calculatedPayments[] = [
                            'id' => 'calc_' . $referredUser->id . '_week2',
                            'amount' => 1000,
                            'payment_type' => 'Week 2 Transaction Bonus',
                            'referral_name' => $referredUser->fname . ' ' . $referredUser->lname,
                            'created_at' => $referredUser->created_at->addWeeks(2)->format('Y-m-d H:i:s')
                        ];
                        $totalPending += 1000;
                    }
                }
            }

            // Subtract any payments already made
            $paidAmount = ReferralPayment::where('user_id', $userId)
                ->where('payment_status', 'paid')
                ->sum('amount');

            $totalPending = max($totalPending - $paidAmount, 0);

            return response()->json([
                'user' => [
                    'id' => $user->id,
                    'name' => $user->fname . ' ' . $user->lname,
                    'business_name' => $user->business->business_name ?? 'N/A'
                ],
                'payments' => $calculatedPayments,
                'total_pending' => $totalPending
            ]);
        }

        $totalPending = $pendingPayments->sum('amount');

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->fname . ' ' . $user->lname,
                'business_name' => $user->business->business_name ?? 'N/A'
            ],
            'payments' => $pendingPayments->map(function($payment) {
                return [
                    'id' => $payment->id,
                    'amount' => $payment->amount,
                    'payment_type' => ucfirst(str_replace('_', ' ', $payment->payment_type)),
                    'referral_name' => $payment->referral ? ($payment->referral->fname . ' ' . $payment->referral->lname) : 'N/A',
                    'created_at' => $payment->created_at->format('Y-m-d H:i:s')
                ];
            }),
            'total_pending' => $totalPending
        ]);
    }
}
