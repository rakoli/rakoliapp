<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Business;
use App\Models\Location;
use App\Models\Network;
use App\Models\Package;
use App\Models\Shift;
use App\Utils\Datatables\Admin\BusinessDataTable;
use App\Utils\Datatables\Admin\RegistingUserDataTable;
use App\Utils\Datatables\Admin\SalesUserDataTable;
use App\Utils\Datatables\Admin\UserDataTable;
use App\Utils\Enums\UserTypeEnum;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Validator;
use Yajra\DataTables\Html\Builder;

class BusinessController extends Controller
{
    public function listbusiness(Builder $datatableBuilder, BusinessDataTable $businessDataTable)
    {
        if (\request()->ajax()) {
            return ($businessDataTable->index());
        }
        return view('admin.business.listbusiness',[
            'dataTableHtml' => $businessDataTable->columns(datatableBuilder: $datatableBuilder),
        ]);
    }

    public function listusers(Builder $datatableBuilder, UserDataTable $userDatatable)
    {
        if (\request()->ajax()) {
            return ($userDatatable->index());
        }
        return view('admin.business.listusers',[
            'dataTableHtml' => $userDatatable->columns(datatableBuilder: $datatableBuilder),
        ]);

    }
    public function registeringuser(Builder $datatableBuilder, RegistingUserDataTable $userDatatable)
    {
        if (\request()->ajax()) {
            return ($userDatatable->index());
        }

        return view('admin.business.registeringusers',[
            'dataTableHtml' => $userDatatable->columns(datatableBuilder: $datatableBuilder),
        ]);
    }

    public function salesUsers(Builder $datatableBuilder, SalesUserDataTable $salesUserDatatable)
    {
        if (\request()->ajax()) {
            return ($salesUserDatatable->index());
        }
        return view('admin.business.sales_users',[
            'dataTableHtml' => $salesUserDatatable->columns(datatableBuilder: $datatableBuilder),
        ]);

    }

    public function createUser(){
        return view('admin.business.add_user');
    }

    public function storeUser(Request $request){

        $validated = $request->validate([
            'country_code' => 'required|exists:countries,code',
            'business_code' => 'required|unique:businesses,code',
            'business_name' => 'required',
            'fname' => 'required',
            'lname' => 'required',
            'business_phone_number' => 'required|numeric',
            'business_email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'business_location' => 'required',
        ], [
            'country_code.required' => 'Please select country',
            'country_code.exists' => 'Country does not exist',
            'business_code.required' => 'Business code is required',
            'business_code.unique' => 'Business code is already exists',
            'business_name.required' => 'Business Name is required',
            'fname.required' => 'First Name is required',
            'lname.required' => 'Last Name is required',
            'business_phone_number.required' => 'Phone is required',
            'business_email.required' => 'Email is required',
            'business_email.email' => 'Email is invalid',
            'business_email.unique' => 'Email is already exists',
            'password.required' => 'Password is required',
            'business_location.required' => 'Business Location is required',
        ]);

        DB::beginTransaction();

        try {

            $user = User::addUser([
                'type' => UserTypeEnum::SALES->value,
                'country_code' => $request->get('country_code'),
                'fname' => $request->get('fname'),
                'lname' => $request->get('lname'),
                'email' => $request->get('business_email'),
                'phone' => $request->get('business_phone_number'),
                'password' => $request->get('password'),
            ]);

            $business = Business::addBusiness([
                'country_code' => $request->get('country_code'),
                'code' => $request->get('business_code'),
                'type' => UserTypeEnum::SALES->value,
                'business_name' => $request->get('business_name'),
                'business_email' => $request->get('business_email'),
                'business_phone_number' => $request->get('business_phone_number'),
                'business_location' => $request->get('business_location'),
                'is_verified' => 1,
                'package_code' => Package::where('country_code',$request->get('country_code'))->where('name','elite')->first()->code ?? NULL,
                'package_expiry_at' => Carbon::now()->addDays('365')
            ],$user);

            $user->business_code = $business->code;
            $user->save();

            DB::commit();
            return redirect()->route('admin.business.users.sales')->with(['message' => 'Sales added Successfully']);
        }catch (\Exception $exception) {
            DB::rollback();
            Log::debug("SALES USER ERROR: ".$exception->getMessage());
            Bugsnag::notifyException($exception);
            return redirect()->back()->withError(['message' => 'Something went wrong, please try after sometime.']);
        }
    }

    public function resetBusiness($business_code){
        Log::info("Business Reset Process Stared :: ".$business_code);
        $business = Business::where('code',$business_code)->first();
        if(!$business){
            return redirect()->back()->withError(['message' => 'Business Details not found']);
        }
        DB::beginTransaction();
        try {
            $location_status = Location::where('business_code',$business_code)->update(['capital' => 0,'balance' => 0]);
            Log::info("Business Capital Updated");

            $shift_status = Shift::where('business_code',$business_code)->delete();
            Log::info("Business Shifts Deleted :: ".$shift_status);

            $network_status = Network::where('business_code',$business_code)->delete();
            Log::info("Business Networks Deleted :: ".$network_status);

            DB::commit();
            return redirect()->back()->with(['message' => 'Business data reset Successfully']);
        }catch (\Exception $exception) {
            DB::rollback();
            Log::debug("SALES USER ERROR: ".$exception->getMessage());
            return redirect()->back()->withError(['message' => 'Something went wrong, please try after sometime.']);
        }



    }

    public function viewbusiness($code){
        $business = Business::where('code',$code)->first();
        if(!$business){
            return redirect()->back()->withError(['message' => 'Business Details not found']);
        }
        
        $user = User::where('business_code', $code)->first();
        
        return view('admin.business.viewbusiness',[
            'business' => $business,
            'user' => $user
        ]);
    }

    public function editbusiness($code){
        $business = Business::where('code',$code)->first();
        if(!$business){
            return redirect()->back()->withError(['message' => 'Business Details not found']);
        }

        $packages = Package::where('country_code', $business->country_code)
            ->pluck('name', 'code')
            ->toArray();

        $countries = \DB::table('countries')
            ->pluck('name', 'code')
            ->toArray();

        return view('admin.business.editbusiness',[
            'business' => $business,
            'packages' => $packages,
            'countries' => $countries
        ]);
    }

    public function updatebusiness(Request $request, $code){
        $business = Business::where('code',$code)->first();
        if(!$business){
            return redirect()->back()->withError(['message' => 'Business Details not found']);
        }

        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'business_email' => 'required|email|max:255',
            'business_phone_number' => 'required|string|max:20',
            'business_location' => 'nullable|string|max:255',
            'country_code' => 'required|exists:countries,code',
            'package_code' => 'nullable|exists:packages,code',
            'status' => 'required|in:active,inactive,suspended',
            'is_verified' => 'boolean',
            'is_trial' => 'boolean',
            'tax_id' => 'nullable|string|max:100',
            'business_regno' => 'nullable|string|max:100',
            'business_reg_date' => 'nullable|date',
            'referral_business_code' => 'nullable|string|max:50',
        ]);

        try {
            $business->update($validated);
            return redirect()->route('admin.business.viewbusiness', ['code' => $code])
                ->with(['message' => 'Business updated successfully']);
        } catch (\Exception $exception) {
            Log::debug("Business Update Error: ".$exception->getMessage());
            Bugsnag::notifyException($exception);
            return redirect()->back()->withError(['message' => 'Something went wrong, please try again.']);
        }
    }

    public function getPackagesByCountry($countryCode){
        try {
            $packages = Package::where('country_code', $countryCode)
                ->select('code', 'name')
                ->get();

            return response()->json([
                'success' => true,
                'packages' => $packages
            ]);
        } catch (\Exception $exception) {
            Log::debug("Get Packages Error: ".$exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch packages'
            ], 500);
        }
    }
}
