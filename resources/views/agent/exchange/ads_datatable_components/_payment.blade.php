<div class="d-flex flex-column justify-content-center w-250px">
    <div class="fs-6 text-gray-600">
        {{__('Buy (Receive)')}} <div class="fw-semibold text-muted">
            @if(!empty($traderBuyMethods))
                @foreach($traderBuyMethods as $method)
                    {{str_camelcase($method->method_name)}}
                    @if($lastTraderBuy->id != $method->id)
                        |
                    @endif
                @endforeach
            @else
                None
            @endif
        </div>
    </div>
</div>
<!--end::Info-->
<!--begin::Info-->
<div class="d-flex flex-column justify-content-center w-250px">
    <div class="fs-6 text-gray-600">
        {{__('Sell (Give)')}} <div class="fw-semibold text-muted">
            @if(!empty($traderSellMethods))
                @foreach($traderSellMethods as $method)
                    {{str_camelcase($method->method_name)}}
                    @if($lastTraderSell->id != $method->id)
                        |
                    @endif
                @endforeach
            @else
                None
            @endif
        </div>
    </div>
</div>
