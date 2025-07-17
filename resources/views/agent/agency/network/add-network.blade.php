@php use App\Utils\Enums\NetworkTypeEnum; @endphp
<div>
    <form method="post" id="add-network-form">
        @csrf
        <div class="modal-body">

            <div class="row fv-row py-2">

                <div class="col-6">
                    <x-label class="" label="{{ __('Name') }}" for="name"/>
                    <x-input
                        class="form-control-solid   @error('name') form-control-feedback @enderror"
                        name="name"
                        placeholder="{{ __('name') }}"
                        id="name"
                    />
                    <x-helpertext>{{ __('Till Name E.G: M-Pesa') }}</x-helpertext>
                    @error('name')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="col-6">

                    <x-label
                        class=""
                        label="{{ __('general.LBL_NETWORK_TYPE') }}"
                        for="type"
                    />
                    <x-select2
                        modalId="add-network"
                        name="type"
                        placeholder="{{ __('Select a Network Type') }}"
                        id="type"
                    >
                        @foreach(NetworkTypeEnum::cases() as $networkType)
                            <option value="{{ $networkType->value }}">{{ $networkType->label() }}</option>
                        @endforeach
                    </x-select2>
                    <x-helpertext>{{ __('Till Type E.G: Fianace, Crypto') }}</x-helpertext>
                    @error('type')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row fv-row py-2">
                <div class="col-6 finance_data">
                    <x-label
                        class=""
                        label="Select Network Provider"
                        for="fsp_code"
                    />
                    <x-select2
                        modalId="add-network"
                        name="fsp_code"
                        placeholder="{{ __('Select a Network Provider') }}"
                        id="fsp_code"
                    >
                        @foreach($agencies as $agency)
                            <option title="{{ $agency->getLogo() }}" value="{{ $agency->code }}">{{ $agency->name }}</option>
                        @endforeach
                    </x-select2>
                    <x-helpertext>{{ __('general.LBL_TILL_HELPER') }}</x-helpertext>
                    @error('fsp_code')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="col-6 crypto_data">
                    <x-label
                        class=""
                        label="Select Crypto Provider"
                        for="crypto_code"
                    />
                    <x-select2
                        modalId="add-network"
                        name="crypto_code"
                        placeholder="{{ __('Select a Crypto Provider') }}"
                        id="crypto_code"
                    >
                        @foreach($cryptos as $crypto)
                            <option value="{{ $crypto->code }}" data-rate="{{ $crypto->exchange_rate }}">{{ $crypto->name }}</option>
                        @endforeach
                    </x-select2>
                    <x-helpertext>{{ __('Crypto Provider E.G: Bitcoin') }}</x-helpertext>
                    @error('crypto_code')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="col-6">
                    <x-label
                        class=""
                        label="{{ __('general.LBL_CHOOSE_LOCATION') }}"
                        for="location_code"
                    />
                    <x-select2
                        modalId="add-network"
                        name="location_code"
                        placeholder="{{ __('Select a Location') }}"
                        id="location_code"
                    >

                        @foreach($locations as $location)
                            <option value="{{ $location->code }}">{{ $location->name }}</option>
                        @endforeach
                    </x-select2>
                    <x-helpertext>{{ __('general.LBL_TILL_BRANCH') }}</x-helpertext>
                    @error('location_code')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row fv-row py-2 finance_data">
                <div class="col-6">
                    <x-label
                        class=""
                        label="{{ __('general.LBL_TILL_NO') }}"
                        for="agent_no"
                    />
                    <x-input
                        class="form-control-solid   @error('agent_no') form-control-feedback @enderror"
                        name="agent_no"
                        placeholder="{{ __('agent_no') }}"
                        id="agent_no"
                    />
                    <x-helpertext>{{ __('general.TILL_AGENCY_NO') }}</x-helpertext>
                    @error('agent_no')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="col-6">
                    <x-label
                        class=""
                        label="{{ __('Balance') }}"
                        for="balance"
                    />
                    <x-input
                        class="form-control-solid   @error('balance') form-control-feedback @enderror"
                        name="balance"
                        placeholder="{{ __('balance') }}"
                        id="balance"
                    />
                    <x-helpertext>{{ __('general.LBL_TRANSACTION_NOTE') }}</x-helpertext>
                    @error('balance')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row fv-row py-2 crypto_data">
                <div class="col-6">
                    <x-label
                        class=""
                        label="{{ __('Crypto Balance') }}"
                        for="crypto_balance"
                    />
                    <x-input
                        class="form-control-solid   @error('crypto_balance') form-control-feedback @enderror"
                        name="crypto_balance"
                        placeholder="{{ __('balance') }}"
                        id="crypto_balance"
                    />
                    <x-helpertext>{{ __('Crypto Current balance: Note this cannot be updated after you start transcating') }}</x-helpertext>
                    @error('crypto_balance')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="col-6">
                    <x-label
                        class=""
                        label="{{ __('Exchange Rate') }}"
                        for="exchange_rate"
                    />
                    <x-input
                        class="form-control-solid @error('exchange_rate') form-control-feedback @enderror"
                        name="exchange_rate"
                        placeholder="{{ __('Exchange Rate') }}"
                        id="exchange_rate"
                    />
                    <x-helpertext>{{ __('Exchange Rate:') }}</x-helpertext>
                    @error('exchange_rate')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row fv-row py-3">
                <div class="col-12">
                    <x-label
                        label="{{ __('general.LBL_DESCRIPTION') }}"
                        required=""
                        for="description"
                    />
                    <textarea name="description" class="form-control form-control form-control-solid" rows="3"
                              data-kt-autosize="false"></textarea>
                    <x-helpertext>{{ __('general.LBL_TILL_ADD_NOTE') }}</x-helpertext>
                    @error('description')
                    <div class="help-block text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="modal-footer">

            <x-submit-button type="button" id="add-network-button" class="btn btn-primary" label="Add Network"/>
        </div>
    </form>



    @push('js')
        <script>
        jQuery(document).ready(function() {

            jQuery(".finance_data").show();
            jQuery(".crypto_data").hide();

            jQuery("#type").on('change', function(){
                if(jQuery(this).val() == "Crypto"){
                    jQuery(".finance_data").hide();
                    jQuery(".crypto_data").show();
                } else {
                    jQuery(".finance_data").show();
                    jQuery(".crypto_data").hide();
                }
            });

            jQuery("#crypto_code").on("change", function(){
                var rate = jQuery("#crypto_code option:selected").data('rate');
                jQuery("#exchange_rate").val(rate);
            }).change();

            jQuery(document).on("click","#add-network-button", function(){
                if(jQuery("#type").val() == "Crypto"){
                    var validations = [
                        {"name" : "name", "validators" : {}},
                        {"name" : "location_code", "validators" : {}},
                        {"name" : "crypto_balance", "validators" : {}},
                        {"name" : "exchange_rate", "validators" : {}},
                    ];
                } else {
                    var validations = [
                        {"name" : "name", "validators" : {}},
                        {"name" : "location_code", "validators" : {}},
                        {"name" : "agent_no", "validators" : {}},
                        {"name" : "balance", "validators" : {}},
                    ];
                }

                const form = document.getElementById('add-network-form');
                const submitButton = document.getElementById('add-network-button');
                lakoriValidation(validations, form, submitButton, 'post', '{{  route('agency.networks.store') }}',"",true);
            });

            $('#fsp_code').select2({
                templateResult: formatOption,
                templateSelection: formatOption,
                minimumResultsForSearch: Infinity
            });
        });
        </script>
    @endpush


</div>
