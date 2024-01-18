<?php

namespace App\Http\Controllers\Vas;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VasContract;
use App\Models\VasTask;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;


class ContractsController extends Controller
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

            $contracts = VasContract::where('country_code',$user->country_code)
                ->where('vas_business_code',$user->business_code)
                ->with(['country','agent','vas_task'])
                ->orderBy('id','desc');;

            return \Yajra\DataTables\Facades\DataTables::eloquent($contracts)
                ->addColumn('action', function(VasContract $contract) {
                    $content = '<a class="btn btn-secondary btn-sm me-2" href="'.route('vas.contracts.show', $contract->id).'">'.__("View Task").'</a>
                                <a class="btn btn-secondary btn-sm me-2" href="'.route('vas.contracts.edit', $contract->id).'">'.__("Edit").'</a>';
                    return $content;
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->editColumn('id',function($contract) {
                    return idNumberDisplay($contract->id);
                })
                ->toJson();
        }

        //Datatable
        $dataTableHtml = $builder->columns([
            ['data' => 'id', 'title' => __('id')],
            ['data' => 'agent.business_name', 'title' => __("Agent")],
            ['data' => 'vas_task_code', 'title' => __("Task")],
            ['data' => 'title', 'title' => __("Title")],
            ['data' => 'time_start' , 'title' => __("Start Time")],
            ['data' => 'time_start' , 'title' => __("End Time")],
            ['data' => 'action', 'title' => __("Action")],

        ])->responsive(true)
            ->ordering(false)
            ->ajax(route('vas.contracts.index'))
            ->paging(true)
            ->dom('frtilp')
            ->lengthMenu([[25, 50, 100, -1], [25, 50, 100, "All"]]);

        return view('vas.contracts.index',compact('dataTableHtml'));
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
            'vas_task_code' => 'required',
            'agent_business_code' => 'required',
            'title' => 'required',
            'time_start' => 'required|date|after:today',
            'time_end' => 'required|date|after:time_start',
            'notes' => 'required|string|max:200',
        ]);
        $user = $request->user();

        $contractData = [
            'country_code' => $user->country_code,
            'vas_business_code' => $user->business_code,
            'code' => generateCode(Str::random(10),'TZ'),
            'vas_task_code' => $request->vas_task_code,
            'agent_business_code' => $request->agent_business_code,
            'title' => $request->title,
            'time_start' => $request->time_start,
            'time_end' => $request->time_end,
            'notes' => $request->notes,
        ];

        $contract = VasContract::create($contractData);

        return [
            'success'           => true,
            'result'            => "successful",
            'resultExplanation' => "Conntract generated successfully",
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contract = VasContract::find($id);
        return view('vas.contracts.show',compact('contract'));
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
