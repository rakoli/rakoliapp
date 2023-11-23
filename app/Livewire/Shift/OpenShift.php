<?php

namespace App\Livewire\Shift;

use App\Models\Location;
use App\Models\Network;
use App\Models\Shift;
use App\Utils\Enums\ShiftStatusEnum;
use App\Utils\Traits\InteractsWithSweetAlerts;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\LazyCollection;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;


class OpenShift extends Component
{

    use InteractsWithSweetAlerts;

    #[Validate('required|numeric', as: "Cash at hand is required")]
    public $cash_at_hand;

    #[Validate('required', as: "Location is required")]
    public $location_code;


    #[Validate('required|max:255', as: "Notes is required")]
    public $notes;


    public $hasOpenShift;

    public function mount()
    {
        $this->hasOpenShift = Shift::query()->where('status',ShiftStatusEnum::OPEN)->exists();

    }

    protected $listeners = [
        'refreshComponent' => '$refresh'
    ];

    public function closeShift()
    {
        $this->dismissModal("openShift");
        $this->openModal("closeShift");
    }
    public function render()
    {

        $tills = Network::query()->with('agency')->cursor();

        $locations = Location::query()->cursor();

        return view('livewire.shift.open-shift')->with([
            'tills' => $tills,
            'locations' => $locations
        ]);
    }


    public function openShift()
    {

        $this->validate();


        try {


           \App\Actions\Agent\Shift\OpenShift::run(
                cashAtHand: $this->cash_at_hand,
                locationCode: $this->location_code,
                notes: $this->notes
            );

             $this->alert(title: 'shift created');
             $this->refreshDataDatable(tableId: 'shift-table');
             $this->dismissModal(modalId: "openShift");

             $this->dispatch('refreshComponent');


        }
        catch (\Exception $e)
        {

            $this->alert(title: $e->getMessage(), icon: "warning");

        }
    }



}
