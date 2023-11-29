<?php

namespace App\Livewire\Shift;

use App\Models\Location;
use App\Models\Network;
use App\Models\Shift;
use App\Utils\Enums\ShiftStatusEnum;
use App\Utils\Traits\InteractsWithSweetAlerts;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AddLoan extends Component
{

    use InteractsWithSweetAlerts;

    public  bool $hasOpenShift = false;

    #[Validate('required|numeric')]
    public $amount;


    #[Validate('required|exists:networks,code',as: 'Till is required')]
    public $network_code;


    #[Validate('required|exists:locations,code',as: 'Location is required')]
    public $location_code;

    #[Validate('required|string',as: 'Type is required')]
    public $type;

    #[Validate('required|string',as: 'Type is required')]
    public $notes;


    public function addLoan()
    {
        $validated = $this->validate();

        try {

            \App\Actions\Agent\Shift\AddLoan::run($validated);

            $this->dismissModal("add-loan");
            $this->refreshDataDatable("loans-table");
            $this->alert(
                title: "loan recorded successfully",
            );
        }
        catch (\Exception $e)
        {
            $this->modal(
                icon: "error",
                title: "Something went wrong!",
                text: "loan not created, try again, {$e->getMessage()}"
            );

        }
    }
    public function render()
    {

        $this->hasOpenShift = ! Shift::query()->where('status',ShiftStatusEnum::OPEN)->exists();


        $locations = Location::query()->cursor();
        $networks = Network::query()->cursor();


        return view('livewire.shift.add-loan')->with([
            'locations' => $locations,
            'networks' => $networks,
        ]);
    }
}
