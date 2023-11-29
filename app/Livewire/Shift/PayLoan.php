<?php

namespace App\Livewire\Shift;

use App\Models\Loan;
use Livewire\Attributes\Validate;
use Livewire\Component;

class PayLoan extends Component
{

    #[Validate('required|numeric')]
    public $amount;

    #[Validate('required|numeric')]
    public $payment_method;

    #[Validate('required|numeric')]
    public $reference_no;

    #[Validate('required|date')]
    public $deposited_at;


    public Loan $loan;

    public function render()
    {
        return view('livewire.shift.pay-loan');
    }


    public function payLoan()
    {
        $this->validate();
    }
}
