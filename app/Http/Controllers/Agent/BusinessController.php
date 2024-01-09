<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Business;
use App\Models\Business;
use App\Models\BusinessRole;
use App\Models\ExchangeAds;
use App\Models\ExchangeBusinessMethod;
use App\Models\Location;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Region;
use App\Models\Role;
use App\Models\Towns;
use App\Utils\Enums\ExchangeStatusEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
        $roles = BusinessRole::where('business_code',$user->business_code)->orderBy('id','desc');

        if (request()->ajax()) {
            return \Yajra\DataTables\Facades\DataTables::eloquent($roles)
                ->addColumn('actions', function(BusinessRole $role) {
                    $content = '<button class="btn btn-secondary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#edit_method_modal" onclick="editClicked('.$role->id.')">'.__("Edit").'</button>';
                    $content .= '<button class="btn btn-secondary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#delete_method_modal" onclick="deleteClicked('.$role->id.')">'.__("Delete").'</button>';
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
            ['data' => 'code', 'title' => __('Code')],
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
        return view('agent.business.ads',compact('dataTableHtml', 'orderByFilter','methodsJson'));
    }

    public function rolesCreate()
    {
        // $businessCode = \auth()->user()->business_code;
        // $branches = Location::where('business_code',$businessCode)->get();
        // $regions = Region::where('country_code',session('country_code'))->get();
        // $businessExchangeMethods = ExchangeBusinessMethod::where('business_code',$businessCode)->get();
        return view('agent.business.roles_create');
    }

    public function rolesAdd(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string'
        ]);

        BusinessRole::create([
            'business_code' => $request->user()->business_code,
            // 'code' => $request->user()->code,
            'code' => generateCode($request->name, $request->user()->business_code),
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->back()->with(['message'=>__('Business Role').' '.__('Added Successfully')]);
    }

    public function rolesCreateSubmit(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:3', 'unique:roles,name']
        ]);
        $roles = new Role();
        $roles->name = $request->name;
        $roles->guard_name = "web";
        $roles->save();
        return redirect()->route('business.role')->with(['message' => 'Role create successfully.']);
    }
    public function rolesEdit(Request $request)
    {
        $request->validate([
            'edit_id' => 'required|exists:business_roles,id',
            'edit_name' => 'required|string',
            'edit_description' => 'required|string',
        ]);

        $BusinessRole = BusinessRole::where('id', $request->edit_id)->first();

        // $isAllowed = $exchangeBusinessMethod->isUserAllowed($request->user());
        // if($isAllowed == false){
        //     return redirect()->route('exchange.methods')->withErrors(['Not authorized to access method']);
        // }

        $BusinessRole->name = $request->edit_name;
        $BusinessRole->description = $request->edit_description;
        $BusinessRole->save();

        return redirect()->back()->with(['message'=>__('Business Role').' '.__('Edited Successfully')]);
    }

    public function rolesEditSubmit(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'name' => ['required', 'min:3', Rule::unique('roles', 'name')->ignore($request->get('role_id'))]
        ]);

        $role = Role::where('id',$request->get('role_id'))->first();

        // $isAllowed = $role->isUserAllowed($request->user());
        // if($isAllowed == false){
        //     return redirect()->route('business.role')->withErrors(['Not authorized to access transaction']);
        // }
        $role->name = $request->get('name');
        $role->save();

        return redirect()->route('business.role')->with(['message'=>'Role Edited Successfully']);
    }

    public function rolesDelete(Request $request)
    {
        $request->validate([
            'delete_id' => 'required|exists:business_roles,id',
        ]);

        $BusinessRole = BusinessRole::where('id', $request->delete_id)->first();

        // $isAllowed = $BusinessRole->isUserAllowed($request->user());
        // if($isAllowed == false){
        //     return redirect()->route('exchange.methods')->withErrors(['Not authorized to access method']);
        // }

        $BusinessRole->delete();

        return redirect()->back()->with(['message'=>__('Business Role').' '.__('Deleted Successfully')]);
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
            $location = Location::query(); // Assuming you have a Location model associated with the locations table

            return \Yajra\DataTables\Facades\DataTables::eloquent($location)
                ->addColumn('actions', function (Location $location) { // Corrected model class name
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
            'balance_currency' => $request->balance_currency,
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
        // $isAllowed = $branches->isUserAllowed($request->user());
        // if($isAllowed == false){
        //     return redirect()->route('business.branches')->withErrors(['Not authorized to access transaction']);
        // }
        // $businessCode = \auth()->user()->business_code;
        // $branches = Location::where('business_code',$businessCode)->get();
        $regions = Region::where('country_code', session('country_code'))->get();
        $towns = null;
        $areas = null;
        if ($branches->region_code != null) {
            $towns = Towns::where('region_code', $branches->region_code)->get();
        }

        if ($branches->town_code != null) {
            $areas = Area::where('town_code', $branches->town_code)->get();
        }
        return view('agent.business.branches_edit', compact('branches', 'regions', 'towns', 'areas'));
    }

    public function branchesEditSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'balance' => 'required|numeric',
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
            'balance_currency' => $request->balance_currency,
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

        $branchesId = $request->input('branches_id');
        Location::where('id', $branchesId)->update($branchesData);

        return redirect()->route('business.branches')->with(['message' => 'branches Edited Successfully']);
    }

    public function branchesDelete(Request $request, $id)
    {
        $location = Location::where('id', $id)->first();
        if (empty($location)) {
            return redirect()->back()->withErrors(['Invalid Exchange Ad']);
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
            'data'=> $towns
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
            'data'=> $towns
        ];
    }



    public function profileUpdate(Request $request)
    {
        $request->validate([
            'business_id' => 'required|exists:businesses,id',
            // 'business_email' => ['required', Rule::unique('businesses', 'business_email')->ignore($request->get('business_id'))],
            // 'business_phone_number' => ['required', Rule::unique('businesses', 'business_phone_number')->ignore($request->get('business_id'))]
        ]);

        $business = Business::where('id',$request->get('business_id'))->first();

        // $isAllowed = $role->isUserAllowed($request->user());
        // if($isAllowed == false){
        //     return redirect()->route('business.role')->withErrors(['Not authorized to access transaction']);
        // }
        $business->business_name = $request->get('business_name');
        $business->tax_id = $request->get('tax_id');
        $business->business_regno = $request->get('business_regno');
        $business->business_reg_date = $request->get('business_reg_date');
        $business->business_phone_number = $request->get('business_phone_number');
        $business->business_email = $request->get('business_email');
        $business->business_location = $request->get('business_location_');
        $business->save();

        return redirect()->route('business.profile.update')->with(['message'=>'Profile Updated Successfully']);
    }
}
