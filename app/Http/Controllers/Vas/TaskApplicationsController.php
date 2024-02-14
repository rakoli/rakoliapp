<?php

namespace App\Http\Controllers\Vas;

use App\Http\Controllers\Controller;
use App\Models\VasTask;
use App\Models\VasTaskApplication;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;

class TaskApplicationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(VasTask $task)
    {
        $user = \auth()->user();
        $dataTable = new DataTables();
        $builder = $dataTable->getHtmlBuilder();

        if (request()->ajax()) {

            $applications = VasTaskApplication::where('vas_task_code',$task->code)
                ->with(['agent'])
                ->orderBy('id','asc');;

            return \Yajra\DataTables\Facades\DataTables::eloquent($applications)
                ->addColumn('action', function(VasTaskApplication $application) use($task) {
                    $content = '<a class="btn btn-secondary btn-sm me-2" href="'.route('vas.task.applications.edit', array($task->id, $application->id)).'">'.__("Assign Contract").'</a>';
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
            ['data' => 'agent_business_code', 'title' => __("Applicant Code")],
            ['data' => 'agent.business_name', 'title' => __("Applicant Name")],
            ['data' => 'comment', 'title' => __("Comment")],
            ['data' => 'action', 'title' => __("Action")],

        ])->responsive(true)
            ->ordering(false)
            ->ajax(route('vas.task.applications.index',$task->id))
            ->paging(true)
            ->dom('frtilp')
            ->lengthMenu([[25, 50, 100, -1], [25, 50, 100, "All"]]);

        return view('vas.opportunities.applications.index',compact('dataTableHtml','task'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(VasTask $task)
    {
        return view('agent.applications.create',compact('task'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VasTask $task, Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:200',
        ]);

        $user = $request->user();

        $taskData = [
            'vas_task_code' => $task->code,
            'submitter_user_code' => $user->code,
            'attachment' => $request->attachment,
            'description' => $request->description,
        ];

        $task = VasTaskApplication::create($taskData);

        return redirect()->route('tasks.applications.index',array($task->id))->with(['message'=>'application uploaded sucessfully.']);

    }

    /**
     * Display the specified resource.
     */
    public function show(VasTask $task, string $id)
    {
        $application = VasTaskApplication::find($id);
        return view('agent.applications.show',compact('task','application'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id,VasTaskApplication $application)
    {
        $task = VasTask::find($id);
        return view('vas.opportunities.applications.edit',compact('task','application'));
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
