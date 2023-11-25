<?php

namespace App\Livewire\Transaction;

use App\Models\Location;
use App\Models\Network;
use App\Utils\Enums\TransactionCategoryEnum;
use App\Utils\Enums\TransactionTypeEnum;
use App\Utils\Traits\InteractsWithSweetAlerts;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AddExpense extends Component
{

    use InteractsWithSweetAlerts;


    #[Validate('required', as:  "Location is required ")]
    public $location_code;

    #[Validate('required', as:  "network /Till is required ")]
    public $till_code;

    #[Validate('required|numeric', as:  "Amount is required ")]
    public $amount;

    #[Validate('required', as:  "Notes are required ")]
    public $notes;



    public function addTransaction()
    {
        $validated = $this->validate();

        try {

            $validated['category'] =  TransactionCategoryEnum::EXPENSE;
            $validated['type'] =  TransactionTypeEnum::MONEY_OUT->value;

            \App\Actions\Agent\Shift\AddTransaction::run($validated);


            $this->dismissModal('add-expenses');

            $this->refreshDataDatable('transaction-table');
            $this->modal(
                icon:  "success",title: "success",text: "Expenses Recorded successfully",
            );


        }
        catch (\Exception $e)
        {
            $this->modal(
                icon:  "error",title: "Something Went wrong",text: "Try again !!, {$e->getMessage()}",
            );
        }
    }


    public function render()
    {

        $tills = Network::query()->with('agency')->cursor();

        $locations = Location::query()->cursor();


        return view('livewire.transaction.add-expense', compact('tills','locations'));
    }

}
