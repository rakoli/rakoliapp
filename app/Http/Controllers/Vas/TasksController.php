<?php

namespace App\Http\Controllers\Vas;

use App\Http\Controllers\Controller;
use App\Models\VasTask;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = \auth()->user();
        $dataTable = new DataTables();
        $builder = $dataTable->getHtmlBuilder();

        if (request()->ajax()) {

            $tasks = VasTask::where('vas_business_code',$user->business_code)
                ->with(['country','business','area','region','town'])
                ->orderBy('id','desc');;

            return \Yajra\DataTables\Facades\DataTables::eloquent($tasks)

                ->editColumn('task_type', function($task) {
                    return __($task->task_type);
                })
                ->addColumn('action', function(VasTask $task) {
                    return '<a href="'.route('exchange.transactions.view',$task->id).'" class="btn btn-secondary btn-sm">'.__("View").'</a>';
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->editColumn('id',function($task) {
                    return idNumberDisplay($task->id);
                })
                ->toJson();
        }

        //Datatable
        $dataTableHtml = $builder->columns([
            ['data' => 'id', 'title' => __('id')],
            ['data' => 'country.name', 'title' => __("Country")],
            ['data' => 'business.business_name', 'title' => __("Business")],
            ['data' => 'area.name', 'title' => __("Area")],
            ['data' => 'region.name', 'title' => __("Region")],
            ['data' => 'town.name', 'title' => __("Town")],
            ['data' => 'task_type' , 'title' => __("Type")],
            ['data' => 'time_start' , 'title' => __("Start Time")],
            ['data' => 'time_start' , 'title' => __("End Time")],
            ['data' => 'no_of_agents' , 'title' => __("Agents")],
            ['data' => 'description' , 'title' => __("Description")],

        ])->responsive(true)
            ->ordering(false)
            ->ajax(route('vas.tasks.index'))
            ->paging(true)
            ->dom('frtilp')
            ->lengthMenu([[25, 50, 100, -1], [25, 50, 100, "All"]]);

        return view('vas.tasks.index',compact('dataTableHtml'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
