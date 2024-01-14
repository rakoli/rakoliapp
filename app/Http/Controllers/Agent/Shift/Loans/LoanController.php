<?php

namespace App\Http\Controllers\Agent\Shift\Loans;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Network;
use App\Models\Shift;
use App\Utils\Datatables\Agent\Shift\LoanDatatable;
use App\Utils\Enums\ShiftStatusEnum;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;

class LoanController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request, LoanDatatable $loanDatatable, Builder $datatableBuilder)
    {
        if ($request->ajax()) {
            return $loanDatatable->index();
        }

        $hasOpenShift = ! Shift::query()->where('status', ShiftStatusEnum::OPEN)->exists();

        $locations = Location::query()->cursor();
        $networks = Network::query()->cursor();

        return view('agent.agency.loans')->with([
            'datatableHtml' => $loanDatatable->columns($datatableBuilder),
            'locations' => $locations,
            'networks' => $networks,
            'hasOpenShift' => $hasOpenShift,
        ]);
    }
}
