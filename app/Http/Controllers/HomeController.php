<?php

namespace App\Http\Controllers;

use App\DataTables\Admin\SystemIncomeDataTable;
use App\Models\SystemIncome;
use App\Utils\Enums\UserTypeEnum;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(SystemIncomeDataTable $dataTable)
    {
        //ADMIN DASHBOARD
        if (auth()->user()->type == UserTypeEnum::ADMIN->value){
            //Datatable Data
            if (request()->ajax()) {
                $recentIncome = SystemIncome::latest()->take(10)->get();
                return DataTables::of($recentIncome)->toJson();
            }

            return $dataTable->render('dashboard.admin');

        }

        //VAS DASHBOARD
        if (auth()->user()->type == UserTypeEnum::VAS->value){

            return view('dashboard.agent');
        }

        //AGENT DASHBOARD
        if (auth()->user()->type == UserTypeEnum::AGENT->value){


            return view('dashboard.agent');
        }

        return 'INVALID DASHBOARD REQUEST';
    }

    public function registrationAgent()
    {

        return view('auth.registration_agent.index');
    }

    public function registrationVas()
    {

        return view('auth.registration_vas.index');
    }
}
