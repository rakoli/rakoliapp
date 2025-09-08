<?php

namespace App\Http\Controllers\Agent\Shift;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Location;
use App\Models\Network;
use App\Models\Shift;
use App\Models\ShiftNetwork;
use App\Models\ShiftTransaction;
use App\Utils\Datatables\Agent\Shift\ShiftCashTransactionDatatable;
use App\Utils\Datatables\Agent\Shift\ShiftTransactionDatatable;
use App\Utils\Enums\NetworkTypeEnum;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;

class ShowShiftController extends Controller
{
    public function __invoke(Request $request, Shift $shift, Builder $datatableBuilder, ShiftTransactionDatatable $transactionDatatable, ShiftCashTransactionDatatable $cashTransactionDatatable)
    {
        if ($request->ajax()) {
            if($request->has('isCash')){
                return $cashTransactionDatatable->index($shift);
            } else if($request->has('isCrypto')){
                return $transactionDatatable->index($shift,NetworkTypeEnum::CRYPTO);
            } else {
                return $transactionDatatable->index($shift,NetworkTypeEnum::FINANCE);
            }
        }

        $dataTableHtml = $transactionDatatable->columns(datatableBuilder: $datatableBuilder)->responsive(true);

        $tills = ShiftNetwork::query()->where('shift_networks.shift_id', $shift->id)->with(['network.agency','network.crypto']);

        $locations = Location::query()->where('code', $shift->location_code)->cursor();

        $till_networks = Network::query()->where('type', NetworkTypeEnum::FINANCE)->get();

        $loans = Loan::query()
            ->latest()
            ->whereBelongsTo($shift, 'shift')
            ->with('location', 'shift', 'network.agency', 'user')
            ->selectRaw('*, note')
            ->get();

        // Calculate commissions for each network based on transactions
        $commissions = ShiftTransaction::query()
            ->where('shift_id', $shift->id)
            ->with(['network.agency'])
            ->whereHas('network.agency') // Only include transactions with FSP
            ->selectRaw('
                network_code,
                type,
                SUM(amount) as total_amount,
                COUNT(*) as transaction_count
            ')
            ->groupBy('network_code', 'type')
            ->get()
            ->map(function ($transaction) {
                $commission = 0;
                $rate = 0;

                if ($transaction->network && $transaction->network->agency) {
                    if ($transaction->type === \App\Utils\Enums\TransactionTypeEnum::MONEY_OUT) {
                        $rate = $transaction->network->agency->withdraw_commission_rate;
                        $commission = $transaction->network->agency->calculateWithdrawCommission($transaction->total_amount);
                    } elseif ($transaction->type === \App\Utils\Enums\TransactionTypeEnum::MONEY_IN) {
                        $rate = $transaction->network->agency->deposit_commission_rate;
                        $commission = $transaction->network->agency->calculateDepositCommission($transaction->total_amount);
                    }
                }

                return [
                    'network' => $transaction->network,
                    'transaction_type' => $transaction->type,
                    'total_amount' => $transaction->total_amount,
                    'transaction_count' => $transaction->transaction_count,
                    'commission_rate' => $rate,
                    'commission_amount' => $commission,
                ];
            });

            return view('agent.agency.show', [
            'dataTableHtml' => $dataTableHtml,
            'loans' => $loans,
            'locations' => $locations,
            'commissions' => $commissions,
            ...shiftBalances(shift: $shift),
            'tills' => $tills->cursor(),
            'shift' => $shift->loadMissing('user', 'location'),
            'till_networks' => $till_networks,
        ]);
    }

}
