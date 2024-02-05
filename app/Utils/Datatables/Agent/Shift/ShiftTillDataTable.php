<?php

namespace App\Utils\Datatables\Agent\Shift;

use App\Models\Shift;
use App\Models\ShiftNetwork;
use App\Utils\Datatables\LakoriDatatable;
use Yajra\DataTables\Facades\DataTables;

class ShiftTillDataTable
{
    use LakoriDatatable;

    public function index(Shift $shift)
    {

        $shifts = ShiftNetwork::query()->where('shift_id', $shift->id)->with('network.agency');

        return Datatables::eloquent($shifts)

            ->filter(function ($query) {
                $query->skip(request('start'))->take(request('length'));
            })
            ->order(function ($query) {
                return $query->orderBy('id', 'desc');
            })
            ->addIndexColumn()
            ->addColumn('balance_old', fn (ShiftNetwork $shiftNetwork) => money(amount: $shiftNetwork->balance_old, currency: currencyCode() , convert:  true))
            ->addColumn('balance_new', fn (ShiftNetwork $shiftNetwork) => money(amount: $shiftNetwork->balance_new, currency: currencyCode() , convert:  true))
            ->addColumn('till_name', fn (ShiftNetwork $shiftNetwork) => $shiftNetwork->network?->agency->name)
            ->addColumn('created_at', fn (ShiftNetwork $shiftNetwork) => $shiftNetwork->created_at->format('Y-F-d'))
            ->addColumn('action', function (ShiftNetwork $shiftNetwork) {

                return (new self())->buttons([
                ]);
            })
            ->rawColumns(['created_at', 'action'])
            ->toJson();
    }
}
