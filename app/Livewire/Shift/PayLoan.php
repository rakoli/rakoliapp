<?php

namespace App\Livewire\Shift;

use App\Actions\Agent\Shift\PayLoanAction;
use App\Models\Loan;
use App\Utils\Traits\InteractsWithSweetAlerts;
use Livewire\Attributes\Validate;
use Livewire\Component;

class PayLoan extends Component
{

    use InteractsWithSweetAlerts;


    #[Validate('required|numeric')]
    public $amount;

    #[Validate('required')]
    public $payment_method;

    #[Validate('required|date')]
    public $deposited_at;


    public Loan $loan;


    public function payLoan()
    {
        $validated = $this->validate();

        try {

            PayLoanAction::run(
                loan: $this->loan,data: $validated
            );


            $this->modal(
                icon: "success",
                title: __( "Loan Paid"),
                text: __( "Loan Paid Successfully")
            );

            $this->refreshDataDatable('loans-payment-table');
            $this->dismissModal('receive-loan-payment');

        }
        catch (\Exception $e)
        {

            $this->modal(
                icon: "warning",
                title: __("Something Went Wrong!"),
                text: " {$e->getMessage()}"
            );

        }
    }
    public function render()
    {

        return view('livewire.shift.pay-loan');
    }



}
