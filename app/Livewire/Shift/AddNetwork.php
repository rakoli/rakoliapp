<?php

namespace App\Livewire\Shift;

use App\Actions\Agent\Shift\AddLocationNetwork;
use App\Models\FinancialServiceProvider;
use App\Models\Location;
use App\Utils\Traits\InteractsWithSweetAlerts;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AddNetwork extends Component
{

    use InteractsWithSweetAlerts;


    #[Validate('required')]
    public $name;

    #[Validate('required')]
    public $agent_no;

    #[Validate('required',as: 'Financial service provider is required')]
    public $fsp_code;

    #[Validate('required|numeric',as: 'Till Balance is required')]
    public $balance;

    #[Validate('required',as: 'Location is required')]
    public $location_code;



    #[Validate('sometimes',as: 'Notes is required')]
    public $notes;



    public function addNetwork()
    {
        $validated = $this->validate();

        try {
            AddLocationNetwork::run($validated);

            $this->dismissModal("add-network");
            $this->refreshDataDatable("network-table");
            $this->alert(
                title: "network recorded successfully",
            );
        }
        catch (\Exception $e)
        {
            $this->modal(
                icon: "error",
                title: "Something went wrong!",
                text: "Network not created, try again, {$e->getMessage()}"
            );
        }
    }
    public function render()
    {
        $locations = Location::query()->cursor();

        $fsps = FinancialServiceProvider::query()->cursor();

        return view('livewire.shift.add-network')->with([
            'locations' => $locations,
            'agencies' => $fsps
        ]);
    }
}
