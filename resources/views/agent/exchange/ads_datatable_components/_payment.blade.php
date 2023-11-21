<div class="d-flex flex-column justify-content-center w-250px">
    <div class="fs-6 text-gray-600">
        Buy (Get) <div class="fw-semibold text-muted">
            @if(!empty($buyMethods))
                @foreach($buyMethods as $method)
                    {{str_camelcase($method->method_name)}}
                    @if($lastBuy->id != $method->id)
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
        Sell (Give) <div class="fw-semibold text-muted">
            @if(!empty($buyMethods))
                @foreach($sellMethods as $method)
                    {{str_camelcase($method->method_name)}}
                    @if($lastSell->id != $method->id)
                    |
                    @endif
                @endforeach
            @else
                None
            @endif
        </div>
    </div>
</div>
