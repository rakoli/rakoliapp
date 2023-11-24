<?php

namespace App\Livewire\Transaction;

use App\Models\Location;
use App\Models\Network;
use App\Utils\Enums\TransactionCategoryEnum;
use App\Utils\Traits\InteractsWithSweetAlerts;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AddTransaction extends Component
{

    use InteractsWithSweetAlerts;


    #[Validate('required', as:  "Location is required ")]
    public $location_code;

    #[Validate('required', as:  "network /Till is required ")]
    public $till_code;

    #[Validate('required|numeric', as:  "Amount is required ")]
    public $amount;

    #[Validate('required', as:  "Transaction Type is required ")]
    public $type;

    #[Validate('required', as:  "Notes are required ")]
    public $notes;
    public function render()
    {

        $tills = Network::query()->with('agency')->cursor();

        $locations = Location::query()->cursor();


        return view('livewire.transaction.add-transaction', compact('tills','locations'));
    }


    public function addTransaction()
    {
        $validated = $this->validate();

        try {

            $validated['category'] =  TransactionCategoryEnum::GENERAL;

            \App\Actions\Agent\Shift\AddTransaction::run($validated);


            $this->dismissModal('add-transaction');

            $this->refreshDataDatable('transaction-table');
            $this->modal(
                icon:  "success",title: "success",text: "Transaction Added successfully",
            );


        }
        catch (\Exception $e)
        {
            $this->modal(
                icon:  "error",title: "Something Went wrong",text: "Try again {$e->getMessage()}",
            );
        }
    }
}
