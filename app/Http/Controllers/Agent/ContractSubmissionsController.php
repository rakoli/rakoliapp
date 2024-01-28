<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\VasContract;
use App\Models\VasSubmission;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;

class ContractSubmissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(VasContract $contract)
    {
        $user = \auth()->user();
        $dataTable = new DataTables();
        $builder = $dataTable->getHtmlBuilder();

        if (request()->ajax()) {

            $submissions = VasSubmission::where('vas_contract_code',$contract->code)
                ->where('submitter_user_code',$user->code)
                ->with(['submitter'])
                ->orderBy('id','desc');;

            return \Yajra\DataTables\Facades\DataTables::eloquent($submissions)
                ->addColumn('reviewer', function(VasSubmission $submission){
                    return $submission->reviewer ? $submission->reviewer->fname." ".$submission->reviewer->lname : 'Not Assigned';
                })
                ->addColumn('action', function(VasSubmission $submission) use($contract) {
                    $content = '<a class="btn btn-secondary btn-sm me-2" href="'.route('contracts.submissions.show', array($contract->id, $submission->id)).'">'.__("View").'</a>';
                    return $content;
                })
                ->editColumn('status',function($contract){
                    return str_camelcase($contract->status);
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
            ['data' => 'reviewer', 'title' => __("Reviewer")],
            ['data' => 'status', 'title' => __("Status")],
            ['data' => 'description', 'title' => __("Description")],
            ['data' => 'action', 'title' => __("Action")],

        ])->responsive(true)
            ->ordering(false)
            ->ajax(route('contracts.submissions.index',$contract->id))
            ->paging(true)
            ->dom('frtilp')
            ->lengthMenu([[25, 50, 100, -1], [25, 50, 100, "All"]]);

        return view('agent.submissions.index',compact('dataTableHtml','contract'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(VasContract $contract)
    {
        return view('agent.submissions.create',compact('contract'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VasContract $contract, Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:200',
        ]);

        $user = $request->user();

        $taskData = [
            'vas_contract_code' => $contract->code,
            'submitter_user_code' => $user->code,
            'attachment' => $request->attachment,
            'description' => $request->description,
        ];

        $task = VasSubmission::create($taskData);

        return redirect()->route('contracts.submissions.index',array($contract->id))->with(['message'=>'Submission uploaded sucessfully.']);

    }

    /**
     * Display the specified resource.
     */
    public function show(VasContract $contract, string $id)
    {
        $submission = VasSubmission::find($id);
        return view('agent.submissions.show',compact('contract','submission'));
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

    public function fileUpload(VasContract $contract, Request $request)
    {
        $file = $request->file($request->attachment);

        $path = $file->store("uploads/contracts/{$contract->code}", 'local');

        $url = Storage::disk('local')->url($path);

        return response()->json(['url' => $url], 200);

    }
}
