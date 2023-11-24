<?php

namespace App\Utils\Datatables\Agent\Shift;

use App\Models\Shift;
use App\Utils\Datatables\LakoriDatatable;
use App\Utils\Enums\ShiftStatusEnum;
use Yajra\DataTables\Facades\DataTables;

class ShiftDatatable
{

    use LakoriDatatable;


    public function index()
    {
        $shifts = Shift::query()->with('user');


        return Datatables::eloquent($shifts)
            ->filter(function ($query) {
                $query->skip(request('start'))->take(request('length'));
            })
            ->order(function ($query) {
                return $query->orderBy('status', 'desc');
            })
            ->addIndexColumn()
            ->addColumn('created_at', fn(Shift $shift) => $shift->created_at->format('Y-F-d'))
            ->addColumn('user_name', fn(Shift $shift) => $shift->user->full_name)
            ->addColumn('action', function(Shift  $shift){

                return (new self())->buttons([
                    'Tills' => route('agency.shift.till', $shift),
                    'Transaction' => route('agency.transactions'),
                  //  'Close Shift' => route('shift.show', $shift)
                ]);
            })
            ->addColumn('status',function (Shift $shift){

                $table = new self();

                return $shift->status == ShiftStatusEnum::OPEN ? $table->active() : $table->notActive();
            })
            ->rawColumns(['created_at','action','status'])
            ->toJson();
    }

}
