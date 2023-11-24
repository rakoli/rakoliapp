<?php

namespace App\Http\Controllers\Agent\Shift;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use App\Utils\Datatables\Agent\Shift\ShiftTillDataTable;
use Illuminate\Http\Request;

class TillController extends Controller
{

    public function index(Shift $shift)
    {
        if (\request()->ajax())
        {
            return  (new ShiftTillDataTable())->index(shift: $shift);
        }
        return view('agent.agency.tills')->with([
            'shift' => $shift->loadMissing('user')
        ]);
    }
}
