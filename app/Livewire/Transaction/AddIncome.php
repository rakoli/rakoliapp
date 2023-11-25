<?php

namespace App\Livewire\Transaction;

use App\Actions\Agent\Shift\AddIncomeExpenseTransaction;
use App\Models\Location;
use App\Models\Network;
use App\Utils\Enums\TransactionCategoryEnum;
use App\Utils\Enums\TransactionTypeEnum;
use App\Utils\Traits\InteractsWithSweetAlerts;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AddIncome extends Component
{

    use InteractsWithSweetAlerts;


    #[Validate('required', as:  "Location is required ")]
    public $location_code;


    #[Validate('required|numeric', as:  "Amount is required ")]
    public $amount;


    #[Validate('required', as:  "Notes are required ")]
    public $notes;



    public function addTransaction()
    {
        $validated = $this->validate();

        try {

            $validated['category'] =  TransactionCategoryEnum::INCOME;
            $validated['type'] =  TransactionTypeEnum::MONEY_IN->value;

           AddIncomeExpenseTransaction::run($validated);


            $this->dismissModal('add-income');

            $this->refreshDataDatable('transaction-table');
            $this->modal(
                icon:  "success",title: "success",text: "Income Added successfully",
            );


        }
        catch (\Exception $e)
        {
            $this->modal(
                icon:  "error",title: "Something Went wrong",text: "Try again {$e->getMessage()}",
            );
        }
    }

    public function render()
    {
        $locations = Location::query()->cursor();
        return view('livewire.transaction.add-income', compact('locations'));
    }

}
