<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\ExchangeBusinessMethod;
use App\Models\Location;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Region;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
                ->addColumn('actions', function(Role $role) {
                    $content = '<a class="btn btn-secondary btn-sm me-2" href="'.route('business.roles.edit', $role->id).'">'.__("Edit").'</a>';
                    $content .= '<button class="btn btn-secondary btn-sm me-2" onclick="deleteClicked('.$role->id.')">'.__("Delete").'</button>';
                    
                    return $content;
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
    
        return view('agent.business.ads',compact('dataTableHtml', 'orderByFilter'));
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

    public function profileCreate (Request $request){
        // dd('dd');
        $businessCode = \auth()->user()->business_code;
        $branches = Location::where('business_code',$businessCode)->get();
        $regions = Region::where('country_code',session('country_code'))->get();
        $businessExchangeMethods = ExchangeBusinessMethod::where('business_code',$businessCode)->get();

        return view('agent.business.profile_create', compact('branches','regions','businessExchangeMethods'));
    }

    public function rolesEdit(Request $request, $id)
    {
        $role = Role::where('id',$id)->first();
        if(empty($role)){
            return redirect()->back()->withErrors(['Invalid Role Id']);
        }
        return view('agent.business.roles_edit', compact('role'));
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

    public function rolesDelete(Request $request, $id)
    {
        $role = Role::where('id',$id)->first();
        if(empty($role)){
            return redirect()->back()->withErrors(['Invalid Exchange Ad']);
        }

        // $isAllowed = $exchangeAd->isUserAllowed($request->user());
        // if($isAllowed == false){
        //     return redirect()->route('exchange.posts')->withErrors(['Not authorized to access transaction']);
        // }
        Role::where('id',$id)->delete();

        return redirect()->route('business.role')->with(['message'=>'Role Deleted Successfully']);
    }
}
