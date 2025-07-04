<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Business;
use App\Utils\StatisticsService;
use App\Utils\DataTableColumn;
use App\Utils\DataTableBuilder;
use App\Traits\DataTableable;
use Illuminate\Http\Request;
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
                    //$content .= '<a class="btn btn-secondary btn-sm me-2" href="' . route('admin.business.viewuser', $user->id) . '">' . __("View User") . '</a>';
                    return $content;
                })
                ->addColumn('name', function (User $user) {
                    return "$user->fname $user->lname";
                })
                ->addColumn('total_referrals', function (User $user) {
                    return $user->referredUsers ? $user->referredUsers->count() : 0;
                })
                ->addColumn('active_referrals', function (User $user) {
                    if (!$user->referredUsers) return 0;
                    return $user->referredUsers->filter(function($referredUser) {
                        return $referredUser->business && $referredUser->business->package_code;
                    })->count();
                })
                ->addColumn('total_commission', function (User $user) {
                    if (!$user->referredUsers) return session('currency', 'TZS') . ' ' . number_format(0, 2);
                    $totalCommission = $user->referredUsers->sum(function($referredUser) {
                        return $referredUser->business && $referredUser->business->package
                            ? $referredUser->business->package->price_commission ?? 0
                            : 0;
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
                ->rawColumns(['actions', 'registration_status', 'package_status', 'business_name'])
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
                $this->createActionsColumn()
                    ->width('200px'),
            ])
            ->responsive(true)
            ->ordering(false)
            ->searching(true)
            ->ajax(route('admin.referrals.index', $orderBy))
            ->paging(true)
            ->dom('frtilp')
            ->lengthMenu([[25, 50, 100, -1], [25, 50, 100, "All"]])
            ->build();

        $stats = [
            'total_sales_users' => User::where('type', 'sales')->count(),
            'total_referrals' => User::whereNotNull('referral_business_code')->count(),
            'active_referrals' => User::whereNotNull('referral_business_code')
                ->whereHas('business', function($q) {
                    $q->whereNotNull('package_code');
                })->count(),
            'total_commission' => User::whereNotNull('referral_business_code')
                ->whereHas('business.package')
                ->with('business.package')
                ->get()
                ->sum(function($user) {
                    return $user->business->package->price_commission ?? 0;
                })
        ];

        return view('admin.referrals', compact('dataTableHtml', 'orderByFilter', 'stats'));
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
                ->rawColumns(['actions', 'registration_status', 'package_status', 'business_name'])
                ->addIndexColumn()
                ->make(true);
        }

        $dataTableHtml = $this->createDataTableBuilder()
            ->columns([
                DataTableColumn::make('business_name')
                    ->title(__('Business Name'))
                    ->searchable()
                    ->width('200px'),
                $this->createPhoneColumn(),
                $this->createStatusColumn('registration_status', __('Reg Status'))
                    ->width('120px'),
                $this->createStatusColumn('package_status', __('Package Status'))
                    ->width('140px'),
                $this->createAmountColumn('commission_value', __('Commission Value')),
                $this->createDateColumn('created_at', __('Referred Date')),
                $this->createActionsColumn(),
            ])
            ->responsive(true)
            ->ordering(false)
            ->searching(true)
            ->ajax(route('admin.referrals.view', [$userId, $orderBy]))
            ->paging(true)
            ->dom('frtilp')
            ->lengthMenu([[25, 50, 100, -1], [25, 50, 100, "All"]])
            ->build();

        $stats = [
            'total_referrals' => $salesUser->referredUsers->count(),
            'active_referrals' => $salesUser->referredUsers->filter(function($user) {
                return $user->business && $user->business->package_code;
            })->count(),
            'inactive_referrals' => $salesUser->referredUsers->filter(function($user) {
                return !$user->business;
            })->count(),
            'total_commission' => $salesUser->referredUsers->sum(function($user) {
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
}
