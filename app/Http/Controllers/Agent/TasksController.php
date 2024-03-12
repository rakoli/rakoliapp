<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\ExchangeBusinessMethod;
use App\Models\Location;
use App\Models\Region;
use App\Models\Towns;
use App\Models\VasSubmission;
use App\Models\VasTask;
use App\Models\VasTaskApplication;
use App\Utils\Enums\VasTaskStatusEnum;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Auth;


class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($type = "")
    {
        $user = \auth()->user();
        $dataTable = new DataTables();
        $builder = $dataTable->getHtmlBuilder();
        if (request()->ajax()) {

            $tasks = VasTask::where('status',VasTaskStatusEnum::ACTIVE->value)
                ->with(['country','business','area','region','town'])
                ->orderBy('id','desc');

            if($type){
                $tasks = $tasks->where('is_public',"0")->whereHas('vas_task_availabilities',function($query) use($user){
                    $query->where('agent_business_code',$user->business_code);
                });
            }
            else {
                $tasks = $tasks->where('is_public',"1");
            }

            return \Yajra\DataTables\Facades\DataTables::eloquent($tasks)
                ->editColumn('task_type', function($task) {
                    return __($task->task_type);
                })
                ->addColumn('location', function(VasTask $task) {
                    $region = $task->region;
                    if($region != null){
                        $region = $task->region->name;
                    }
                    $town = $task->town;
                    if($town != null){
                        $town = $task->town->name;
                    }
                    $area = $task->area;
                    if($area != null){
                        $area = $task->area->name;
                    }
                    $content = "<div class='d-flex flex-column'>
                                  <div>Region: $region</div>
                                  <div>Town: $town</div>
                                  <div>Area: $area</div>
                                </div>";

                    return $content;
                })
                ->addColumn('action', function(VasTask $task) {
                    $content = '<a class="btn btn-secondary btn-sm me-2" href="'.route('agent.task.show', $task->id).'">'.__("View Task").'</a>';
                    return $content;
                })
                ->addIndexColumn()
                ->rawColumns(['action','location'])
                ->editColumn('id',function($task) {
                    return idNumberDisplay($task->id);
                })
                ->toJson();
        }

        //Datatable
        $dataTableHtml = $builder->columns([
            ['data' => 'id', 'title' => __('id')],
            ['data' => 'business.business_name', 'title' => __("Business")],
            ['data' => 'location', 'title' => __("Location")],
            ['data' => 'task_type' , 'title' => __("Type")],
            ['data' => 'time_start' , 'title' => __("Start Time")],
            ['data' => 'time_start' , 'title' => __("End Time")],
            ['data' => 'no_of_agents' , 'title' => __("Agents")],
            ['data' => 'description' , 'title' => __("Description")],
            ['data' => 'action' , 'title' => __("Action")],
        ])->responsive(true)
            ->ordering(false)
            ->ajax(route('agent.tasks',array($type)))
            ->paging(true)
            ->dom('frtilp')
            ->lengthMenu([[25, 50, 100, -1], [25, 50, 100, "All"]]);

        return view('agent.tasks.index',compact('dataTableHtml'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $task = VasTask::find($id);
        return view('agent.tasks.show',compact('task'));
    }

    public function apply(Request $request)
    {
        $user = auth()->user();
        $task = VasTask::find($request->task_id);
        $checkSubmission = VasSubmission::where('vas_contract_code',$task->code)->where('submitter_user_code',$user->bussiness_code)->exists();
        if($checkSubmission){
            return [
                'success'           => false,
                'result'            => "failed",
                'resultExplanation' => "You have already applied for task.",
            ];
        }
        $application = new VasTaskApplication;
        $application->vas_task_code = $task->code;
        $application->agent_business_code = $user->business_code;
        $application->comment = $request->comment;
        $application->save();

        return [
            'success'           => true,
            'result'            => "successful",
            'resultExplanation' => "Applied successfully",
        ];
    }

}
