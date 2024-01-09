<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessRole;
use App\Models\ExchangeAds;
use App\Models\ExchangeBusinessMethod;
use App\Models\Location;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Region;
use App\Models\Role;
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
