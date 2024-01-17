<?php

namespace App\Http\Controllers\Vas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\ExchangeBusinessMethod;
use App\Models\Location;
use App\Models\Region;
use App\Models\Towns;
use App\Models\User;
use App\Models\VasTask;
use App\Models\VasTaskAvailability;
use App\Utils\Enums\UserTypeEnum;
use App\Utils\Enums\VasTaskStatusEnum;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;


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

            $tasks = VasTask::where('country_code',$user->country_code)
                ->where('vas_business_code',$user->business_code)
                ->with(['country','business','area','region','town'])
                ->orderBy('id','desc');;

            return \Yajra\DataTables\Facades\DataTables::eloquent($tasks)

                ->editColumn('task_type', function($task) {
                    return __($task->task_type);
                })
                ->addColumn('action', function(VasTask $task) {
                    $content = '<a class="btn btn-secondary btn-sm me-2" href="'.route('vas.tasks.show', $task->id).'">'.__("View Task").'</a>
                                <a class="btn btn-secondary btn-sm me-2" href="'.route('vas.tasks.edit', $task->id).'">'.__("Edit").'</a>';
                    if($task->status != VasTaskStatusEnum::DELETED->value){
                        $content .= '<button class="btn btn-secondary btn-sm me-2" onclick="deleteClicked('.$task->id.')">'.__("Delete").'</button>';
                    }
                    return $content;
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
            ['data' => 'action' , 'title' => __("Action")],
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
        $businessCode = \auth()->user()->business_code;
        $regions = Region::where('country_code',session('country_code'))->get();
        $agents = User::where('type',UserTypeEnum::AGENT->value)->select('business_code','fname','lname')->get();
        $task = new VasTask;
        return view('vas.tasks.create',compact('businessCode','regions','task','agents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'region_code' => 'sometimes',
            'town_code' => 'sometimes',
            'area_code' => 'sometimes',
            'task_type' => 'required',
            'time_start' => 'required|date|after:today',
            'time_end' => 'required|date|after:time_start',
            'no_of_agents' => 'required|numeric',
            'is_public' => 'required',
            'description' => 'required|string|max:200',
        ]);
        $user = $request->user();

        $taskData = [
            'country_code' => $user->country_code,
            'vas_business_code' => $user->business_code,
            'code' => generateCode(Str::random(10),'TZ'),
            'time_start' => $request->time_start,
            'time_end' => $request->time_end,
            'region_code' => $request->region_code,
            'town_code' => $request->town_code,
            'area_code' => $request->area_code,
            'status' => VasTaskStatusEnum::PENDING->value,
            'no_of_agents' => $request->no_of_agents,
            'is_public' => $request->is_public,
            'description' => $request->description,
        ];

        $task = VasTask::create($taskData);

        if($request->is_public == "0" && !empty($request->private_agents))
        {
            foreach($request->private_agents as $code){
                VasTaskAvailability::firstOrCreate(array('vas_task_code' => $task->code, 'agent_business_code' => $code));
            }
        }

        return redirect()->route('vas.tasks.index')->with(['message'=>'Vas Task Submitted']);
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        $task = VasTask::find($id);
        return view('vas.tasks.show',compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VasTask $task)
    {
        $businessCode = \auth()->user()->business_code;
        $agents = User::where('type',UserTypeEnum::AGENT->value)->select('business_code','fname','lname')->get();
        $regions = Region::where('country_code',session('country_code'))->get();
        $towns = null;
        $areas = null;

        if($task->region_code != null){
            $towns = Towns::where('region_code',$task->region_code)->get();
        }

        if($task->town_code != null){
            $areas = Area::where('town_code',$task->town_code)->get();
        }
        return view('vas.tasks.edit',compact('businessCode','agents','regions','towns','areas','task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VasTask $task)
    {
        $request->validate([
            'region_code' => 'sometimes',
            'town_code' => 'sometimes',
            'area_code' => 'sometimes',
            'task_type' => 'required',
            'time_start' => 'required|date|after:today',
            'time_end' => 'required|date|after:time_start',
            'no_of_agents' => 'required|numeric',
            'is_public' => 'required',
            'description' => 'required|string|max:200',
        ]);

        $task->time_start = $request->time_start;
        $task->time_end = $request->time_end;
        $task->region_code = $request->region_code;
        $task->town_code = $request->town_code;
        $task->area_code = $request->area_code;
        $task->no_of_agents = $request->no_of_agents;
        $task->status = $request->status;
        $task->is_public = $request->is_public;
        $task->description = $request->description;
        $task->save();

        if($request->is_public == "0" && !empty($request->private_agents))
        {
            foreach($request->private_agents as $code){
                VasTaskAvailability::firstOrCreate(array('vas_task_code' => $task->code, 'agent_business_code' => $code));
            }
        }

        return redirect()->route('vas.tasks.index')->with(['message'=>'Vas Task Updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VasTask $task)
    {
        $task->status = VasTaskStatusEnum::DELETED->value;
        $task->save();
        return redirect()->route('vas.tasks.index')->with(['message'=>'Vas Task Deleted']);
    }
}
