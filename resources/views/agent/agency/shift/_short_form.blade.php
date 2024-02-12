<div class="shift-has-shorts">
    <div class="row fv-row py-3">
        <div class="col-6">
            <x-label label="Short Amount" required="" for="short value"/>
            <x-input
                readonly="readonly"
                class="total_shorts_input"
            />
        </div>
        <div class="col-6">
            <x-label label="Shift Type" required="" for="shift_type"/>
            <x-select2
                modalId="transfer_shift"
                id="select_shift_type"
                readonly="readonly"
                class="total_shorts_input"
                name="short_type"                       >

                @foreach(\App\Utils\Enums\ShortTypeEnum::cases() as $typeEnum)
                    <option value="{{ $typeEnum->value }}">{{ $typeEnum->value }}</option>
                @endforeach


            </x-select2>
        </div>

        <div class="col-6 mt-4" id="shift_network_code">
            <x-label label="Shift Type" required="" for="shift_network_code"/>
            <x-select2
                modalId="transfer_shift"
                id="shift_network_code"
                readonly="readonly"
                class="total_shorts_input"
                name="short_network_code"
            >
                @foreach($networks as  $name  => $network)
                    <option value="{{ $network['code'] }}">{{ $name }}</option>
                @endforeach

            </x-select2>
        </div>
    </div>
</div>
