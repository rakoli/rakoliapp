<?php

namespace App\Http\Controllers\Agent;

use App\Actions\RequestEmailVerificationCode;
use App\Actions\SendPasswordEmail;
use App\Actions\SendPasswordSms;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Business;
use App\Models\BusinessRole;
use App\Models\Country;
use App\Models\ExchangeAds;
use App\Models\ExchangeBusinessMethod;
use App\Models\ExchangePaymentMethod;
use App\Models\Location;
use App\Models\LocationUser;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Region;
use App\Models\Role;
use App\Models\Towns;
use App\Models\User;
use App\Models\UserRole;
use App\Utils\Enums\ExchangeStatusEnum;
use App\Utils\Enums\UserTypeEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Utils\VerifyOTP;
use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;

class BusinessController extends Controller
{
    public function roles(Request $request)
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
        $roles = BusinessRole::where('business_code', $user->business_code)->orderBy('id', 'desc');

        if (request()->ajax()) {
            return \Yajra\DataTables\Facades\DataTables::eloquent($roles)
                ->addColumn('actions', function (BusinessRole $role) {
                    $content = '<button class="btn btn-secondary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#edit_method_modal" onclick="editClicked(' . $role->id . ')">' . __("Edit") . '</button>';
                    $content .= '<button class="btn btn-secondary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#delete_method_modal" onclick="deleteClicked(' . $role->id . ')">' . __("Delete") . '</button>';
                    return $content;
                })
                ->rawColumns(['actions'])
                ->addIndexColumn()
                ->toJson();
        }

        // DataTable
        $dataTableHtml = $builder->columns([
            ['data' => 'id', 'title' => __('ID')],
            ['data' => 'business_code', 'title' => __('Business Code')],
            // ['data' => 'code', 'title' => __('Code')],
            ['data' => 'name', 'title' => __('Name')],
            ['data' => 'description', 'title' => __('Description')],
            ['data' => 'actions', 'title' => __('Actions')],
        ])->responsive(true)
            ->ordering(false)
            ->ajax(route('business.role', $orderBy)) // Assuming you have a named route for the roles.index endpoint
            ->paging(true)
            ->dom('frtilp')
            ->lengthMenu([[25, 50, 100, -1], [25, 50, 100, "All"]]);

        $methodsJson = $roles->get()->toJson();
        return view('agent.business.roles', compact('dataTableHtml', 'orderByFilter', 'methodsJson'));
    }

    public function rolesAdd(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name|min:3',
            'description' => 'required|string'
        ]);

        BusinessRole::create([
            'business_code' => $request->user()->business_code,
            'code' => generateCode($request->name, $request->user()->business_code),
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('business.role')->with(['message' => __('Business Role') . ' ' . __('Added Successfully')]);
    }

    public function rolesEdit(Request $request)
    {
        $request->validate([
            'edit_id' => 'required|exists:business_roles,id',
            'edit_name' => 'required|string',
            'edit_description' => 'required|string',
        ]);

        $businessRole = BusinessRole::where('id', $request->edit_id)->first();

        $isAllowed = $businessRole->isUserAllowed($request->user());
        if($isAllowed == false){
            return redirect()->route('business.role')->withErrors(['Not authorized to perform business action']);
        }

        $businessRole->name = $request->edit_name;
        $businessRole->description = $request->edit_description;
        $businessRole->save();

        return redirect()->route('business.role')->with(['message' => __('Business Role') . ' ' . __('Edited Successfully')]);
    }

    public function rolesDelete(Request $request)
    {
        $request->validate([
            'delete_id' => 'required|exists:business_roles,id',
        ]);

        $businessRole = BusinessRole::where('id', $request->delete_id)->first();

        $isAllowed = $businessRole->isUserAllowed($request->user());
        if($isAllowed == false){
            return redirect()->route('business.role')->withErrors(['Not authorized to perform business action']);
        }

        $businessRole->delete();

        return redirect()->route('business.role')->with(['message' => __('Business Role') . ' ' . __('Deleted Successfully')]);
    }

    public function profileCreate(Request $request)
    {
        $businessCode = \auth()->user();
        $user = auth()->user();
        $business = $user->business;

        return view('agent.business.profile_create', compact('business'));
    }
    public function branches(Request $request)
    {
        $user = \auth()->user();
        $dataTable = new DataTables();
        $builder = $dataTable->getHtmlBuilder();

        if (request()->ajax()) {
            $location = Location::where('business_code', $user->business_code)->orderBy('id','desc');;
            return \Yajra\DataTables\Facades\DataTables::eloquent($location)
                ->addColumn('actions', function (Location $location) {
                    $content = '<a class="btn btn-secondary btn-sm me-2" href="' . route('business.branches.edit', $location->id) . '">' . __("Edit") . '</a>';
                    $content .= '<button class="btn btn-secondary btn-sm me-2" onclick="deleteClicked(' . $location->id . ')">' . __("Delete") . '</button>';
                    return $content;
                })
                ->rawColumns(['actions'])
                ->addIndexColumn()
                ->toJson();
        }

        // Datatable
        $dataTableHtml = $builder->columns([
            ['data' => 'id', 'title' => __('id')],
            ['data' => 'name', 'title' => __("Name")],
            ['data' => 'balance', 'title' => __("Balance") . ' (' . session('currency') . ')'],
            ['data' => 'balance_currency', 'title' => __("Balance Currency")], // Removed extra space
            ['data' => 'description', 'title' => __("Description")],
            ['data' => 'actions', 'title' => __("Action")], // Corrected column name
        ])->responsive(true)
            ->ordering(false)
            ->ajax(route('business.branches'))
            ->paging(true)
            ->dom('frtilp')
            ->lengthMenu([[25, 50, 100, -1], [25, 50, 100, "All"]]);

        return view('agent.business.branches', compact('dataTableHtml'));
    }
    public function branchesCreate()
    {
        $businessCode = \auth()->user()->business_code;
        // $branches = Location::where('business_code',$businessCode)->get();
        $regions = Region::where('country_code', session('country_code'))->get();
        $businessExchangeMethods = ExchangeBusinessMethod::where('business_code', $businessCode)->get();

        return view('agent.business.branch_create', compact('regions', 'businessExchangeMethods'));
    }
    public function branchesCreateSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'balance' => 'required|numeric',
            'availability_desc' => 'sometimes|string|max:255|nullable',
        ]);
        $user = $request->user();

        $currency = session('currency');
        if ($currency == null) {
            $currency = $user->business->country->currency;
        }

        $branchesData = [
            'business_code' => $request->user()->business_code,
            'name' => $request->name,
            'balance' => $request->balance,
            'balance_currency' => $currency,
            'description' => $request->availability_desc,
            'code' => generateCode($request->name, $request->user()->business_code),

        ];

        $region = $request->get('ad_region');
        if ($region != 'all') {
            $regionModel = Region::where('code', $region)->get();
            if ($regionModel->isNotEmpty()) {
                $branchesData['region_code'] = $regionModel->first()->code;
            }
        }

        $town = $request->get('ad_town');
        if ($town != 'all') {
            $townModel = Towns::where('code', $town)->get();
            if ($townModel->isNotEmpty()) {
                $branchesData['town_code'] = $townModel->first()->code;
            }
        }

        $area = $request->get('ad_area');
        if ($area != 'all') {
            $areaModel = Area::where('code', $area)->get();
            if ($areaModel->isNotEmpty()) {
                $branchesData['area_code'] = $areaModel->first()->code;
            }
        }
        $branches = Location::create($branchesData);
        return redirect()->route('business.branches')->with(['message' => 'branches Submitted']);
    }
    public function branchesEdit(Request $request, $id)
    {
        $branches = Location::where('id', $id)->first();
        if (empty($branches)) {
            return redirect()->back()->withErrors(['Invalid Branches']);
        }
        $regions = Region::where('country_code', session('country_code'))->get();
        $towns = null;
        $areas = null;
        if ($branches->region_code != null) {
            $towns = Towns::where('region_code', $branches->region_code)->get();
        }

        if ($branches->town_code != null) {
            $areas = Area::where('town_code', $branches->town_code)->get();
        }

        $isAllowed = $branches->isUserAllowed($request->user());
        if($isAllowed == false){
            return redirect()->route('business.branches')->withErrors(['Not authorized to perform business action']);
        }

        return view('agent.business.branches_edit', compact('branches', 'regions', 'towns', 'areas'));
    }

    public function branchesEditSubmit(Request $request)
    {
        $request->validate([
            'branches_id' => 'required|exists:locations,id',
            'name' => 'required',
            'balance' => 'required|numeric',
            'availability_desc' => 'sometimes|string|max:255|nullable',
        ]);
        $user = $request->user();

        $currency = session('currency');
        if ($currency == null) {
            $currency = $user->business->country->currency;
        }

        $branchesData = [
            'name' => $request->name,
            'balance' => $request->balance,
            'balance_currency' => $currency,
            'description' => $request->availability_desc,
        ];

        $region = $request->get('ad_region');
        if ($region != 'all') {
            $regionModel = Region::where('code', $region)->get();
            if ($regionModel->isNotEmpty()) {
                $branchesData['region_code'] = $regionModel->first()->code;
            }
        }

        $town = $request->get('ad_town');
        if ($town != 'all') {
            $townModel = Towns::where('code', $town)->get();
            if ($townModel->isNotEmpty()) {
                $branchesData['town_code'] = $townModel->first()->code;
            }
        }

        $area = $request->get('ad_area');
        if ($area != 'all') {
            $areaModel = Area::where('code', $area)->get();
            if ($areaModel->isNotEmpty()) {
                $branchesData['area_code'] = $areaModel->first()->code;
            }
        }

        $branchesId = $request->input('branches_id');

        $location = Location::where('id', $branchesId)->first();
        $isAllowed = $location->isUserAllowed($request->user());
        if($isAllowed == false){
            return redirect()->route('business.branches')->withErrors(['Not authorized to perform business action']);
        }

        $location->update($branchesData);

        return redirect()->route('business.branches')->with(['message' => 'branches Edited Successfully']);
    }

    public function branchesDelete(Request $request, $id)
    {
        $location = Location::where('id', $id)->first();
        if (empty($location)) {
            return redirect()->back()->withErrors(['Invalid BranchId Ad']);
        }

        $isAllowed = $location->isUserAllowed($request->user());
        if($isAllowed == false){
            return redirect()->route('business.branches')->withErrors(['Not authorized to perform business action']);
        }

        $location->delete();

        return redirect()->route('business.branches')->with(['message' => 'branches Deleted Successfully']);
    }


    public function branchesCreateTownlistAjax(Request $request)
    {
        $request->validate([
            'region_code' => 'required|exists:regions,code',
        ]);
        $towns = Towns::where('region_code', $request->get('region_code'))->get()->toArray();
        return [
            'status' => 200,
            'message' => 'successful',
            'data' => $towns
        ];
    }

    public function branchesCreateArealistAjax(Request $request)
    {
        $request->validate([
            'town_code' => 'required|exists:towns,code',
        ]);
        $towns = Area::where('town_code', $request->get('town_code'))->get()->toArray();
        return [
            'status' => 200,
            'message' => 'successful',
            'data' => $towns
        ];
    }
    public function profileUpdate(Request $request)
    {
        $request->validate([
            'business_id' => 'required|exists:businesses,id',
            'business_name' => 'required|string',
            'tax_id' => 'required|string',
            'business_regno' => 'required|string',
            'business_phone_number' => 'required|numeric',
            'business_email' => 'required|email',
            'business_location_' => 'required|string',
        ]);

        $business = Business::where('id', $request->get('business_id'))->first();

        $isAllowed = $business->isUserAllowed($request->user());
        if($isAllowed == false){
            return redirect()->route('business.profile.update')->withErrors(['Not authorized to perform business action']);
        }

        $business->business_name = $request->get('business_name');
        $business->tax_id = $request->get('tax_id');
        $business->business_regno = $request->get('business_regno');
        $business->business_reg_date = $request->get('business_reg_date');
        $business->business_phone_number = $request->get('business_phone_number');
        $business->business_email = $request->get('business_email');
        $business->business_location = $request->get('business_location_');
        $business->save();

        return redirect()->route('business.profile.update')->with(['message' => 'Profile Updated Successfully']);
    }


    public function users()
    {
        $user = \auth()->user();
        $dataTable = new DataTables();
        $builder = $dataTable->getHtmlBuilder();
        $users = User::where('business_code', $user->business_code)->orderBy('id', 'desc');

        if (request()->ajax()) {

            return \Yajra\DataTables\Facades\DataTables::eloquent($users)
                ->addColumn('action', function (User $trn) {
                    $content = '<a class="btn btn-secondary btn-sm me-2" href="' . route('business.users.edit', $trn->id) . '">' . __("Edit") . '</a>';
                    $content .= '<button class="btn btn-secondary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#delete_method_modal" onclick="deleteClicked(' . $trn->id . ')">' . __("Delete") . '</button>';
                    return $content;
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->editColumn('status', function ($method) {
                    if ($method->status == 1) {
                        return 'active';
                    } else {
                        return 'inactive';
                    }
                })
                ->editColumn('id', function ($method) {
                    return idNumberDisplay($method->id);
                })
                ->toJson();
        }
        //Datatable
        $dataTableHtml = $builder->columns([
            ['data' => 'id', 'title' => __('id')],
            ['data' => 'fname', 'title' => __("Name")],
            ['data' => 'lname', 'title' => __("Last Name")],
            ['data' => 'phone', 'title' => __("Phone Number")],
            ['data' => 'email', 'title' => __("Email")],
            ['data' => 'action', 'title' => __("Action")],
        ])->responsive(true)
            ->ordering(false)
            ->ajax(route('business.users'))
            ->paging(true)
            ->dom('frtilp')
            ->lengthMenu([[25, 50, 100, -1], [25, 50, 100, "All"]]);
        $methodsJson = $users->get()->toJson();
        return view('agent.business.users', compact('dataTableHtml', 'methodsJson'));
    }
    public function usersCreate()
    {
        $user = \auth()->user()->business_code;
        $branches = Location::where('business_code', $user)->get();
        $businessRole = BusinessRole::where('business_code', $user)->get();

        return view('agent.business.users_create', compact('branches', 'businessRole', 'user'));
    }

    public function usersCreateSubmit(Request $request)
    {
        $request->validate([
            'fname' => 'required|string',
            'lname' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'password' => 'required|string|min:8',
            'branches' => 'required',
            'roles' => 'required|exists:business_roles,code',
        ]);
        $user = $request->user();
        $usersData = [
            'country_code' => $user->country_code,
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'phone' => $request->phone,
            'type' => UserTypeEnum::AGENT->value,
            'password' => Hash::make($request->password),
            'business_code' => $request->user()->business_code,
            'code' => generateCode($request->fname, $request->user()->business_code),
        ];
        $newUser = User::create($usersData);

        $roles = $request->input('roles');
        $locations = $request->input('branches');
        foreach ($locations as $location) {
            LocationUser::create([
                'user_code' => $newUser->code,
                'business_code' => $newUser->business_code,
                'location_code' => $location,
            ]);
        }
        UserRole::create([
            'user_code' => $newUser->code,
            'business_code' => $newUser->business_code,
            'user_role' => $roles,
        ]);
        return redirect()->route('business.users')->with(['message' => 'Added User Successfully']);
    }

    public function usersEdit(Request $request, $id)
    {
        $users = User::where('id', $id)->first();
        $user = \auth()->user()->business_code;
        $locationdata = LocationUser::where('user_code', $users->code)->get();
        if (empty($users)) {
            return redirect()->back()->withErrors(['Invalid Branches']);
        }
        $branches = Location::where('business_code', $user)->get();
        $businessRole = BusinessRole::where('business_code', $user)->get();

        return view('agent.business.users_edit', compact('users', 'branches', 'businessRole', 'locationdata'));
    }
    public function usersEditSubmit(Request $request)
    {
        $request->validate([
            'users_id' => 'required|numeric|exists:users,id',
            'fname' => 'required|string',
            'lname' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required',
            'password' => 'sometimes|string|min:8|nullable',
            'branches' => 'required',
            'roles' => 'required|exists:business_roles,code',
        ]);
        $user = User::where('id', $request->users_id)->firstOrFail();

        $isAllowed = $user->isUserAllowed($request->user());
        if($isAllowed == false){
            return redirect()->route('business.users')->withErrors(['Not authorized to perform business action']);
        }

        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->save();

        $locationUser = LocationUser::where('user_code', $user->code)->get();
        $userRole = UserRole::where('user_code', $user->code)->get();
        $locationUser->each->delete();
        $userRole->each->delete();
        $locations = $request->input('branches');
        $roles = $request->input('roles');

        foreach ($locations as $location) {
            LocationUser::create([
                'user_code' => $user->code,
                'business_code' => $user->business_code,
                'location_code' => $location,
            ]);
        }
        UserRole::create([
            'user_code' => $user->code,
            'business_code' => $user->business_code,
            'user_role' => $roles,
        ]);
        return redirect()->route('business.users')->with(['message' => 'users Edited Successfully']);
    }
    public function usersDelete(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        if (empty($user)) {
            return redirect()->back()->withErrors(['Invalid User Id']);
        }

        if($request->user()->id == $id){
            return redirect()->back()->withErrors(['You can not delete you own account']);
        }

        $isAllowed = $user->isUserAllowed($request->user());
        if($isAllowed == false){
            return redirect()->route('business.users')->withErrors(['Not authorized to perform business action']);
        }

        $user->delete();

        return redirect()->route('business.users')->with(['message' => 'Users Deleted Successfully']);
    }

    public function referrals(Request $request)
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

        $users = User::where('referral_business_code',$user->business_code)->with('business.package')->orderBy('id', 'desc');
        if (request()->ajax()) {
            return \Yajra\DataTables\Facades\DataTables::eloquent($users)
                ->addColumn('actions', function (User $users) {
                     $content = '<button class="btn btn-secondary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#edit_method_modal" onclick="editClicked()">' . __("Edit") . '</button>';
                     $content .= '<button class="btn btn-secondary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#delete_method_modal" onclick="deleteClicked()">' . __("Delete") . '</button>';
                     return $content;
                })
                ->addColumn('name', function (User $user) {
                    return "$user->fname $user->lname";
                })
                ->addColumn('registration_status', function (User $user) {
                    $business = $user->business;
                    if($business == null){
                        return 'Not Registered';
                    }
                    $package = $business->package_code;
                    if($package == null){
                        return 'Not Active Package';
                    }
                    $package = $user->business->package->name;
                    return $package;
                })
                ->addColumn('package_status', function (User $user) {
                    $business = $user->business;
                    if($business == null){
                        return 'None';
                    }
                    $package = $business->package_code;
                    if($package == null){
                        return 'None';
                    }
                    $package = $user->business->package->name;
                    return $package;
                })
                ->addColumn('business_name', function (User $user) {
                    $business = $user->business;
                    if($business == null){
                        return 'Not Registered';
                    }
                    return $business->business_name;
                })
                ->addColumn('package_commission', function (User $user) {
                    $business = $user->business;
                    if($business == null){
                        return number_format(0,2);
                    }
                    $package = $business->package_code;
                    if($package == null){
                        return number_format(0,2);
                    }
                    $packageCommission = $user->business->package->price_commission;
                    return number_format($packageCommission,2);
                })
                ->rawColumns(['actions'])
                ->addIndexColumn()
                ->toJson();
        }
        // DataTable
        $dataTableHtml = $builder->columns([
            ['data' => 'id', 'title' => __('ID')],
            ['data' => 'name', 'title' => __('Name')],
            ['data' => 'phone', 'title' => __('Phone')],
            ['data' => 'registration_status', 'title' => __('Registration Status')],
            ['data' => 'business_name', 'title' => __('Business Name')],
            ['data' => 'package_status', 'title' => __('Package Status')],
            ['data' => 'package_commission', 'title' => __('Commission')],
        ])->responsive(true)
            ->ordering(false)
            ->ajax(route('business.referrals', $orderBy))
            ->paging(true)
            ->dom('frtilp')
            ->lengthMenu([[25, 50, 100, -1], [25, 50, 100, "All"]]);

        return view('agent.business.referrals', compact('dataTableHtml', 'orderByFilter'));
    }
    public function referr(Request $request)
    {
        $data = $request->validate([
            'country_dial_code' => ['required', 'exists:countries,dialing_code'],
            'fname' => ['required', 'string', 'max:20'],
            'lname' => ['required', 'string', 'max:20'],
            'phone' => ['required', 'numeric'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);
        $business_code = $request->user()->business_code;
        $password = VerifyOTP::generateOTPCode();
        $pass = VerifyOTP::generateHashedPassword($password);
        $country_code = Country::where('dialing_code', $data['country_dial_code'])->first()->code;
        $country_dial_code = substr($data['country_dial_code'], 1);
        $plainPhone = substr($data['phone'], 1);
        $fullPhone = $country_dial_code . $plainPhone;
        $user = User::create([
            'country_code' => $country_code,
            'code' => generateCode($data['fname'] . ' ' . $data['lname'], $country_code),
            'type' => UserTypeEnum::AGENT->value,
            'fname' => $data['fname'],
            'lname' => $data['lname'],
            'phone' => $fullPhone,
            'email' => $data['email'],
            'password' => $pass,
            'referral_business_code' => $business_code,
        ]);
        SendPasswordEmail::dispatch($user);
        // SendPasswordSms::dispatch($user,$password);
        return redirect()->route('business.referrals')->with(['message' => 'Refer Successfully']);
    }

}
