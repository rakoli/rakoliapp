<?php

namespace App\Livewire\Shift;

use App\Models\Location;
use App\Models\Network;
use App\Models\Shift;
use App\Utils\Enums\ShiftStatusEnum;
use App\Utils\Traits\InteractsWithSweetAlerts;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CloseShift extends Component
{
    use InteractsWithSweetAlerts;

    #[Validate('required|numeric', as: "Closing balance is required")]
    public $closing_balance;

    #[Validate('required', as: "Location is required")]
    public $location_code;

    #[Validate('required', as: "Notes is required")]
    public $notes;


    protected $listeners = [
        'refreshComponent' => '$refresh'
    ];

    public function mount()
    {
        $this->closing_balance = Shift::query()->where('status',ShiftStatusEnum::OPEN)->pluck('cash_end')->first();
        $this->location_code = Shift::query()->where('status',ShiftStatusEnum::OPEN)->pluck('location_code')->first();
    }


    public $hasOpenShift;
    public function render()
    {

        $this->hasOpenShift = Shift::query()->where('status',ShiftStatusEnum::OPEN)->exists();


        $tills = Network::query()->with('agency')->cursor();

        $locations = Location::query()->cursor();

        return view('livewire.shift.close-shift')->with([
            'tills' => $tills,
            'locations' => $locations
        ]);
    }

    public function closeShift()
    {

        $this->validate();


        try {



            \App\Actions\Agent\Shift\CloseShift::run(
                closingBalance: $this->closing_balance,
                locationCode: $this->location_code,
                notes: $this->notes
            );

            $this->alert(title: 'shift closed');
            $this->refreshDataDatable(tableId: 'shift-table');
            $this->dismissModal(modalId: "closeShift");
            $this->dispatch('refreshComponent');


        }
        catch (\Exception $e)
        {

            $this->alert(title: $e->getMessage(), icon: "warning");

        }
    }
}
