<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Business;
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

class BusinessController extends Controller
{
    public function roles(Request $request)
    {
        $dataTable = new DataTables();
        $builder = $dataTable->getHtmlBuilder();
        $orderBy = null;
        $orderByFilter = null;

        if ($request->get('order_by')) {
            $orderBy = ['order_by' => $request->get('order_by')];
            $orderByFilter = $request->get('order_by');
        }

        if (request()->ajax()) {
            $roles = Role::query(); // Assuming you have a Role model associated with the roles table

            return \Yajra\DataTables\Facades\DataTables::eloquent($roles)
                ->addColumn('actions', function (Role $role) {
                    // Add any additional actions you want for each role
                    return '<a href="#" class="btn btn-secondary btn-sm">Edit</a>';
                })
                ->rawColumns(['actions'])
                ->addIndexColumn()
                ->toJson();
        }

        // DataTable
        $dataTableHtml = $builder->columns([
            ['data' => 'id', 'title' => __('ID')],
            ['data' => 'name', 'title' => __('Name')],
            ['data' => 'guard_name', 'title' => __('Guard Name')],
            ['data' => 'actions', 'title' => __('Actions')],
        ])->responsive(true)
            ->ordering(false)
            ->ajax(route('business.role', $orderBy)) // Assuming you have a named route for the roles.index endpoint
            ->paging(true)
            ->dom('frtilp')
            ->lengthMenu([[25, 50, 100, -1], [25, 50, 100, "All"]]);

        return view('agent.business.ads', compact('dataTableHtml', 'orderByFilter'));
    }

    public function rolesCreate()
    {
        // $businessCode = \auth()->user()->business_code;
        // $branches = Location::where('business_code',$businessCode)->get();
        // $regions = Region::where('country_code',session('country_code'))->get();
        // $businessExchangeMethods = ExchangeBusinessMethod::where('business_code',$businessCode)->get();
        return view('agent.business.roles_create');
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

    public function profileCreate(Request $request)
    {
        $businessCode = \auth()->user();
        $user = auth()->user();
        $business = $user->business;
        // $branches = Location::where('business_code',$businessCode)->get();
        // $regions = Region::where('country_code',session('country_code'))->get();
        // $businessExchangeMethods = ExchangeBusinessMethod::where('business_code',$businessCode)->get();

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


}
