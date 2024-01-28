<?php

namespace App\Http\Controllers\Vas;

use App\Http\Controllers\Controller;
use App\Models\VasContract;
use App\Models\VasSubmission;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

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
                ->with(['submitter'])
                ->orderBy('id','desc');;

            return \Yajra\DataTables\Facades\DataTables::eloquent($submissions)
                ->addColumn('submitter', function(VasSubmission $submission){
                    return $submission->submitter->fname." ".$submission->submitter->lname;
                })
                ->addColumn('action', function(VasSubmission $submission) use($contract) {
                    $content = '<a class="btn btn-secondary btn-sm me-2" href="'.route('vas.contracts.submissions.show', array($contract->id, $submission->id)).'">'.__("View").'</a>';
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
            ['data' => 'submitter', 'title' => __("Submitter")],
            ['data' => 'status', 'title' => __("Status")],
            ['data' => 'description', 'title' => __("Description")],
            ['data' => 'action', 'title' => __("Action")],

        ])->responsive(true)
            ->ordering(false)
            ->ajax(route('vas.contracts.submissions.index',$contract->id))
            ->paging(true)
            ->dom('frtilp')
            ->lengthMenu([[25, 50, 100, -1], [25, 50, 100, "All"]]);

        return view('vas.submissions.index',compact('dataTableHtml'));
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
    public function show(VasContract $contract, string $id)
    {
        $submission = VasSubmission::find($id);
        return view('vas.submissions.show',compact('contract','submission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VasContract $contract, VasSubmission $submission)
    {
        $submission->update(['status' => $request->status]);
        return redirect()->route('vas.contracts.submissions.show',array($contract->id,$submission->id))->with(['message'=>'Status Updated']);
    }
}
