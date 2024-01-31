<?php

namespace App\Http\Controllers\Vas;

use App\Events\VasChatEvent;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VasChat;
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
                    $content = '<a class="btn btn-secondary btn-sm me-2" href="'.route('vas.contracts.show', $contract->id).'">'.__("View").'</a>
                                <a class="btn btn-secondary btn-sm me-2" href="'.route('vas.contracts.submissions.index', $contract->id).'">'.__("Submissions").'</a>';
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
            'resultExplanation' => "Contract generated successfully",
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contract = VasContract::find($id);
        $chatMessages = $contract->vas_chats->sortBy('id');
        return view('vas.contracts.show',compact('contract','chatMessages'));
    }

    public function contractsReceiveMessage(Request $request)
    {
        $request->validate([
            'contract_id' => 'required|exists:vas_contracts,id',
            'message' => 'required|string|min:1|max:200',
        ]);
        $chatId = $request->get('contract_id');
        $user = $request->user();

        $contractId = $request->get('contract_id');
        $contract = VasContract::where('id',$contractId)->first();
        $isAllowed = $contract->isUserAllowed($user);
        if($isAllowed == false){
            return redirect()->route('vas.contracts.index')->withErrors(['Not authorized to access transaction']);
        }

        VasChat::create([
            'vas_contract_code' => $contract->code,
            'sender_code' => $user->code,
            'message' => $request->get('message'),
        ]);

        if(env('APP_ENV') != 'testing'){
            event(new VasChatEvent($chatId,$request->get('message'),$user->name(),$user->business->business_name,now()->toDateTimeString('minute'),$user->id));
        }

        return [
            'status' => 200,
            'message' => "successful"
        ];
    }
}
