@extends('layouts.users.agent')

@section('title', __("Transaction View"))

@section('header_js')
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
@endsection


@section('content')
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">

        <!--begin::Layout-->
        <div class="d-flex flex-column flex-xl-row">

            <!--begin::Sidebar-->
            <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
                <!--begin::Card-->
                <div class="card mb-5 mb-xl-8">

                    <!--Begin::Card Footer (Actions)-->
                    <div class="card-body pt-5">

                        <!--Begin::Status Details-->
                        <div class="text-center fw-bold">{{__("Status")}}</div>
                        <div class="mb-5 text-gray-600 text-center">
                            {{__(\App\Utils\Enums\ExchangeTransactionStatusEnum::tryFrom($exchangeTransaction->status)->description())}}
                        </div>
                        <!--End::Status Details-->

                        <!--Begin::Action Buttons-->

                        @if($exchangeTransaction->status === \App\Utils\Enums\ExchangeTransactionStatusEnum::OPEN->value )
                            <button type="button" class="btn btn-primary btn-text-danger" data-bs-toggle="modal" data-bs-target="#cancel_modal">
                                {{__('Cancel')}}
                            </button>
                        @endif

                        <!-- Todo: Add Exchange Trade Report-->
{{--                        <button type="button" class="btn btn-primary btn-text-warning" data-bs-toggle="modal" data-bs-target="#report_modal">--}}
{{--                            {{__('Report')}}--}}
{{--                        </button>--}}

                        @if($exchangeTransaction->isTrader(auth()->user())&& $exchangeTransaction->trader_confirm_at == null && $exchangeTransaction->is_complete == false)
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#complete_modal">
                                {{__('Complete')}}
                            </button>
                        @endif

                        @if($exchangeTransaction->isOwner(auth()->user()) && $exchangeTransaction->owner_confirm_at == null && $exchangeTransaction->is_complete == false)
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#complete_modal">
                                {{__('Complete')}}
                            </button>
                        @endif
                        <!--End::Action Buttons-->

                        @if($exchangeTransaction->is_complete == true && $exchangeTransaction->status == \App\Utils\Enums\ExchangeTransactionStatusEnum::COMPLETED->value )

                            @if(($exchangeTransaction->isOwner(auth()->user()) && $exchangeTransaction->owner_submitted_feedback == false) || ($exchangeTransaction->isTrader(auth()->user()) && $exchangeTransaction->trader_submitted_feedback == false))

                                <!--Begin::Status Details-->
                                <div class="mb-2 mt-2 text-gray-600 text-center">
                                    {{__('Submit Transaction Feedback')}}
                                </div>
                                <!--End::Status Details-->

                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#feedback_modal">
                                    {{__('Give Feedback')}}
                                </button>

                            @else

                                <!--begin:Label-->
                                <span class="d-flex align-items-center mb-0 mt-2 align-center">
                                    <!--begin:Info-->
                                    <span class="d-flex flex-column mb-0" >
                                        <span class="fs-6 mb-0">{{__("Feedback Submitted")}}</span>
                                    </span>
                                    <!--end:Info-->

                                    @if($exchangeTransaction->exchange_feedback->where('reviewer_user_code',\auth()->user()->code)->first()->review == true)
                                        <!--begin:Icon-->
                                        <span class="symbol symbol-35px mb-0 m-lg-2">
                                            <span class="symbol-label bg-light-success mb-0">
                                                <i class="ki-duotone ki-shield-tick fs-1 text-success"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                            </span>
                                        </span>
                                        <!--end:Icon-->
                                    @else
                                        <!--begin:Icon-->
                                        <span class="symbol symbol-35px mb-0 m-lg-2">
                                            <span class="symbol-label bg-light-danger mb-0">
                                                <i class="ki-duotone ki-cross-circle fs-1 text-danger"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                            </span>
                                        </span>
                                        <!--end:Icon-->
                                    @endif

                                </span>

                                <div class="text-gray-600">
                                    {{$exchangeTransaction->exchange_feedback->where('reviewer_user_code',\auth()->user()->code)->first()->review_comment}}
                                </div>
                                <!--end:Label-->

                            @endif

                        @endif


                    </div>
                    <!--end::Card Footer (Actions)-->

                    <!--end::Details toggle-->
                    <div class="separator separator-dashed"></div>
                    <!--begin::Details content-->

                    <!--begin::Card body-->
                    <div class="card-body pt-1">
                        <!--begin::Details content-->
                        <div class="collapse show">
                            <div class="py-5 fs-6">

                                <!--begin::Details item-->
                                <div class="fw-bold mt-5">{{__("Order Reference")}}</div>
                                <div class="text-gray-600">{{idNumberDisplay($exchangeTransaction->id)}} ({{__("ad")}}:<a href="{{route('exchange.ads.view',$exchangeAd->id)}}">{{idNumberDisplay($exchangeAd->id)}}</a>)</div>

                                <div class="fw-bold mt-5">{{__("Advertiser")}}</div>
                                <div class="text-gray-600">
                                    {{$exchangeTransaction->owner_business->business_name}}
                                </div>

                                <div class="fw-bold mt-5">{{__("Applicant")}}</div>
                                <div class="text-gray-600">
                                    {{$exchangeTransaction->trader_business->business_name}}
                                </div>
                                <div class="fw-bold mt-5">{{__("Description")}}</div>
                                <div class="text-gray-600">{{$exchangeAd->description}}</div>
                                <!--begin::Details item-->
                                <!--begin::Details item-->
                                <div class="fw-bold mt-5">{{__("Exchange Availability")}}</div>
                                <div class="text-gray-600">{{$exchangeAd->availability_desc}}</div>
                                <!--begin::Details item-->
                                <!--begin::Details item-->
                                <div class="fw-bold mt-5">{{__("Terms")}}</div>
                                <div class="text-gray-600">{{$exchangeAd->terms}}</div>
                                <!--begin::Details item-->
                            </div>
                        </div>
                        <!--end::Details content-->
                    </div>

                </div>
                <!--end::Card-->
            </div>
            <!--end::Sidebar-->

            <!--begin::Content-->
            <div class="flex-lg-row-fluid ms-lg-15">

                <!--begin::Messenger-->
                <div class="card" id="kt_chat_messenger">
                    <!--begin::Card header-->
                    <div class="card-header" id="kt_chat_messenger_header">
                        <!--begin::Title-->
                        <div class="card-title">
                            <!--begin::User-->
                            <div class="d-flex justify-content-center flex-column me-3">
                                <a href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 mb-2 mt-5 lh-1">{{__("Trade Chat")}}</a>
                                <!--begin::Info-->
                                <div class="mb-5 lh-1">
                                    <span class="fs-7 fw-semibold text-muted">
                                        @if($exchangeTransaction->owner_business->code == auth()->user()->business_code)
                                            {{__(tradeOrderInvence($exchangeTransaction->trader_action_type))}} {{number_format($exchangeTransaction->amount)}}
                                            {{strtolower($exchangeTransaction->amount_currency)}} {{__('of')}} {{strtolower($exchangeTransaction->trader_target_method)}} {{__('using')}} {{strtolower($exchangeTransaction->trader_action_via_method)}}
                                        @endif

                                        @if($exchangeTransaction->trader_business->code == auth()->user()->business_code)
                                            {{__($exchangeTransaction->trader_action_type)}} {{number_format($exchangeTransaction->amount)}}
                                            {{strtolower($exchangeTransaction->amount_currency)}} {{__('of')}} {{strtolower($exchangeTransaction->trader_target_method)}} {{__('using')}} {{strtolower($exchangeTransaction->trader_action_via_method)}}
                                        @endif
                                    </span>
                                </div>
                                <!--end::Info-->

                            </div>
                            <!--end::User-->
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body" id="kt_chat_messenger_body">
                        <!--begin::Messages-->
                        <div class="scroll-y me-n5 pe-5 h-400px h-lg-auto" id="messageScroll" data-kt-element="messages" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_app_header, #kt_app_toolbar, #kt_toolbar, #kt_footer, #kt_app_footer, #kt_chat_messenger_header, #kt_chat_messenger_footer" data-kt-scroll-wrappers="#kt_content, #kt_app_content, #kt_chat_messenger_body" data-kt-scroll-offset="5px">


                            @foreach($chatMessages as $chatMessage)

                                @if($chatMessage->user->business_code == auth()->user()->business->code)

                                    <!--begin::Message(out)-->
                                    <div class="d-flex justify-content-end mb-10" data-kt-element="template-out">
                                        <!--begin::Wrapper-->
                                        <div class="d-flex flex-column align-items-end">
                                            <!--begin::User-->
                                            <div class="d-flex align-items-center mb-2">
                                                <!--begin::Details-->
                                                <div class="me-3">
                                                    <span class="text-muted fs-7 mb-1">{{$chatMessage->created_at}}</span>
                                                    <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary ms-1">You ({{$chatMessage->user->business->business_name}})</a>
                                                </div>
                                                <!--end::Details-->
                                                <!--begin::Avatar-->
                                                <div class="symbol symbol-35px symbol-circle">
                                                    <img alt="Pic" src="{{asset('assets/media/avatars/blank.png')}}" />
                                                </div>
                                                <!--end::Avatar-->
                                            </div>
                                            <!--end::User-->
                                            <!--begin::Text-->
                                            <div class="p-5 rounded bg-light-primary text-dark fw-semibold mw-lg-400px text-end" data-kt-element="message-text">{{$chatMessage->message}}</div>
                                            <!--end::Text-->
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
                                    <!--end::Message(out)-->

                                @else

                                    <!--begin::Message(in)-->
                                    <div class="d-flex justify-content-start mb-10" data-kt-element="template-in">
                                        <!--begin::Wrapper-->
                                        <div class="d-flex flex-column align-items-start">
                                            <!--begin::User-->
                                            <div class="d-flex align-items-center mb-2">
                                                <!--begin::Avatar-->
                                                <div class="symbol symbol-35px symbol-circle">
                                                    <span class="symbol-label bg-light-info text-info fw-semibold" data-kt-element="message-sender-initial">{{substr($chatMessage->user->name(), 0, 1)}}</span>
                                                </div>
                                                <!--end::Avatar-->
                                                <!--begin::Details-->
                                                <div class="ms-3">
                                                    <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary me-1" data-kt-element="message-sender">{{$chatMessage->user->name()}} ({{$chatMessage->user->business->business_name}})</a>
                                                    <span class="text-muted fs-7 mb-1" data-kt-element="message-created-at">{{$chatMessage->created_at}}</span>
                                                </div>
                                                <!--end::Details-->
                                            </div>
                                            <!--end::User-->
                                            <!--begin::Text-->
                                            <div class="p-5 rounded bg-light-info text-dark fw-semibold mw-lg-400px text-start" data-kt-element="message-text">{{$chatMessage->message}}</div>
                                            <!--end::Text-->
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
                                    <!--end::Message(in)-->

                                @endif

                            @endforeach


                            <!-- TEMPLATE MESSAGES -->
                                <!--begin::Message(in)-->
                                <div class="d-flex justify-content-start mb-10 d-none" data-kt-element="template-in">
                                    <!--begin::Wrapper-->
                                    <div class="d-flex flex-column align-items-start">
                                        <!--begin::User-->
                                        <div class="d-flex align-items-center mb-2">
                                            <!--begin::Avatar-->
                                            <div class="symbol symbol-35px symbol-circle">
                                                <span class="symbol-label bg-light-info text-info fw-semibold" data-kt-element="message-sender-initial"></span>
                                            </div>
                                            <!--end::Avatar-->
                                            <!--begin::Details-->
                                            <div class="ms-3">
                                                <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary me-1" data-kt-element="message-sender"></a>
                                                <span class="text-muted fs-7 mb-1" data-kt-element="message-created-at"></span>
                                            </div>
                                            <!--end::Details-->
                                        </div>
                                        <!--end::User-->
                                        <!--begin::Text-->
                                        <div class="p-5 rounded bg-light-info text-dark fw-semibold mw-lg-400px text-start" data-kt-element="message-text"></div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Message(in)-->
                                <!--begin::Message(out)-->
                                <div class="d-flex justify-content-end mb-10 d-none" data-kt-element="template-out">
                                    <!--begin::Wrapper-->
                                    <div class="d-flex flex-column align-items-end">
                                        <!--begin::User-->
                                        <div class="d-flex align-items-center mb-2">
                                            <!--begin::Details-->
                                            <div class="me-3">
                                                <span class="text-muted fs-7 mb-1">{{now()->toDateTimeString('minute')}}</span>
                                                <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary ms-1">You ({{\Illuminate\Support\Facades\Auth::user()->business->business_name}})</a>
                                            </div>
                                            <!--end::Details-->
                                            <!--begin::Avatar-->
                                            <div class="symbol symbol-35px symbol-circle">
                                                <img alt="Pic" src="{{asset('assets/media/avatars/blank.png')}}" />
                                            </div>
                                            <!--end::Avatar-->
                                        </div>
                                        <!--end::User-->
                                        <!--begin::Text-->
                                        <div class="p-5 rounded bg-light-primary text-dark fw-semibold mw-lg-400px text-end" data-kt-element="message-text"></div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Message(out)-->
                            <!-- END::TEMPLATE MESSAGES -->

                        </div>
                        <!--end::Messages-->
                    </div>
                    <!--end::Card body-->
                    <!--begin::Card footer-->
                    <div class="card-footer pt-4" id="kt_chat_messenger_footer">
                        <!--begin::Input-->
                        <textarea class="form-control form-control-flush mb-3" rows="1" data-kt-element="input" placeholder="Type a message"></textarea>
                        <!--end::Input-->
                        <!--begin:Toolbar-->
                        <div class="d-flex flex-stack">
                            <!--begin::Actions-->
                            <div class="d-flex align-items-center me-2">
                                <button class="btn btn-sm btn-icon btn-active-light-primary me-1" type="button" data-bs-toggle="tooltip" title="Coming soon">
                                    <i class="ki-outline ki-paper-clip fs-3"></i>
                                </button>
                                <button class="btn btn-sm btn-icon btn-active-light-primary me-1" type="button" data-bs-toggle="tooltip" title="Coming soon">
                                    <i class="ki-outline ki-exit-up fs-3"></i>
                                </button>
                            </div>
                            <!--end::Actions-->
                            <!--begin::Send-->
                            <a class="btn btn-secondary" href="{{route('exchange.transactions')}}">{{__('Go Back')}}</a>
                            <button id="sentTextButton" class="btn btn-primary" type="button" data-kt-element="send">{{__('Send')}}</button>
                            <!--end::Send-->
                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Card footer-->

                    <!--begin::Example-->
                    <div class="separator separator-content border-dark my-5"><span class="w-250px fw-bold">{{__("Payment Method")}}</span></div>
                    <!--end::Example-->

                    <div class="card-body">
                        <div class="input-group input-group-solid input-group-sm mb-5">
                            <span class="input-group-text">{{__('Financial Institution')}}</span>
                            <input type="text" class="form-control" value="{{str_camelcase($exchangeTransaction->paymentMethod->method_name)}}" disabled/>
                        </div>
                        <div class="input-group input-group-solid input-group-sm mb-5">
                            <span class="input-group-text">{{__("Account Name")}}</span>
                            <input id="kt_clipboard_acname" type="text" class="form-control" value="{{str_camelcase($exchangeTransaction->paymentMethod->account_name)}}" readonly/>
                            <button class="btn btn-primary" data-clipboard-target="#kt_clipboard_acname">Copy</button>
                        </div>
                        <div class="input-group input-group-solid input-group-sm mb-5">
                            <span class="input-group-text">{{__("Account Number")}}</span>
                            <input id="kt_clipboard_acnumber" type="text" class="form-control" value="{{str_camelcase($exchangeTransaction->paymentMethod->account_number)}}" readonly/>
                            <button class="btn btn-primary" data-clipboard-target="#kt_clipboard_acnumber">Copy</button>
                        </div>
                    </div>

                </div>
                <!--end::Messenger-->
            </div>
            <!--end::Content-->

            <!--begin::ACTION MODULES-->
            <div class="modal fade" tabindex="-1" id="complete_modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">{{__("Complete Exchange")}}</h3>
                            <!--begin::Close-->
                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                            </div>
                            <!--end::Close-->
                        </div>

                        <form class="my-auto pb-5" action="{{route('exchange.transactions.action')}}" method="POST">
                            @csrf

                            <input type="hidden" name="ex_trans_id" value="{{$exchangeTransaction->id}}">
                            <input type="hidden" name="action" value="complete">

                            <div class="modal-body">
                                <p>{{__("general.exchange.trades.complete.confirmation")}}</p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__("Close")}}</button>
                                <button type="submit" class="btn btn-primary">{{__('Complete Exchange')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" tabindex="-1" id="report_modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">{{__("Report Exchange")}}</h3>
                            <!--begin::Close-->
                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                            </div>
                            <!--end::Close-->
                        </div>

                        <div class="modal-body">
                            <p>Modal body text goes here.</p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__("Close")}}</button>
                            <button type="submit" class="btn btn-primary">{{__('Report Exchange')}}</button>
                        </div>

                    </div>
                </div>
            </div>

            <div class="modal fade" tabindex="-1" id="cancel_modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">{{__("Cancel Exchange")}}</h3>
                            <!--begin::Close-->
                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                            </div>
                            <!--end::Close-->
                        </div>
                        <form class="my-auto pb-5" action="{{route('exchange.transactions.action')}}" method="POST">
                            @csrf

                            <input type="hidden" name="ex_trans_id" value="{{$exchangeTransaction->id}}">
                            <input type="hidden" name="action" value="cancel">

                            <div class="modal-body">
                                <p>{{__("general.exchange.trades.cancel.confirmation")}}</p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__("Close")}}</button>
                                <button type="submit" class="btn btn-primary">{{__('Cancel Exchange')}}</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

            <div class="modal fade" tabindex="-1" id="feedback_modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">{{__("Submit Exchange Feedback")}}</h3>
                            <!--begin::Close-->
                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                            </div>
                            <!--end::Close-->
                        </div>
                        <form class="my-auto pb-5" action="{{route('exchange.transactions.feedback.action')}}" method="POST">
                            @csrf

                            <input type="hidden" name="ex_trans_id" value="{{$exchangeTransaction->id}}">

                            <div class="modal-body">


                                <!--begin:Option-->
                                <label class="d-flex flex-stack cursor-pointer">
                                    <!--begin:Label-->
                                    <span class="d-flex align-items-center me-2">
                                        <!--begin:Icon-->
                                        <span class="symbol symbol-50px me-6">
                                            <span class="symbol-label bg-light-success">
                                                <i class="ki-duotone ki-shield-tick fs-1 text-success"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                            </span>
                                        </span>
                                        <!--end:Icon-->

                                        <!--begin:Info-->
                                        <span class="d-flex flex-column">
                                            <span class="fw-bold fs-6">{{__("Positive")}}</span>
                                        </span>
                                        <!--end:Info-->
                                    </span>
                                    <!--end:Label-->

                                    <!--begin:Input-->
                                    <span class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="radio" name="feedback" value="1"/>
                                    </span>
                                    <!--end:Input-->
                                </label>
                                <!--end::Option-->

                                <!--begin:Option-->
                                <label class="d-flex flex-stack mb-5 cursor-pointer">
                                    <!--begin:Label-->
                                    <span class="d-flex align-items-center me-2">
                                        <!--begin:Icon-->
                                        <span class="symbol symbol-50px me-6">
                                            <span class="symbol-label bg-light-danger">
                                                <i class="ki-duotone ki-cross-circle fs-1 text-danger"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                            </span>
                                        </span>
                                        <!--end:Icon-->

                                        <!--begin:Info-->
                                        <span class="d-flex flex-column">
                                            <span class="fw-bold fs-6">{{__("Negative")}}</span>
                                        </span>
                                        <!--end:Info-->
                                    </span>
                                    <!--end:Label-->

                                    <!--begin:Input-->
                                    <span class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="radio" name="feedback" value="0"/>
                                    </span>
                                    <!--end:Input-->
                                </label>
                                <!--end::Option-->


                                <!--begin::Input group-->
                                <div class="input-group">
                                    <span class="input-group-text">{{__("Comments")}}</span>
                                    <textarea class="form-control" name="comments" placeholder="{{__("Optional feedback comments")}}"></textarea>
                                </div>
                                <!--end::Input group-->




                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__("Close")}}</button>
                                <button type="submit" class="btn btn-primary">{{__('Submit Feedback')}}</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
            <!--end::ACTION MODULES-->

        </div>
        <!--end::Layout-->

    </div>
    <!--end::Container-->
@endsection

@section('footer_js')

    <script>
        var currentUserId = {{auth()->user()->id}};
        var element = document.querySelector('#kt_chat_messenger');

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = false;

        var pusher = new Pusher("{{env('PUSHER_APP_KEY')}}", {
            cluster: "{{env('PUSHER_APP_CLUSTER')}}"
        });

        var channel = pusher.subscribe('exchange-chat-{{$exchangeTransaction->id}}');
        channel.bind('message-sent', function(data) {
            if(currentUserId !== data.sendUserId){
                var sender = data.usersName + ' ('+data.businesssName+')';
                var senderInitial = sender.charAt(0);
                var createdAt = data.textTime;
                var theText = data.message;
                addIncomingMessage(element,senderInitial,sender,createdAt,theText)
            }
        });
    </script>


    <script>
        "use strict";

        // ChatApp class encapsulates chat-related functions
        class ChatApp {

            // Handles events related to sending messages
            static handleSend(element) {
                if (!element) {
                    return;
                }
                // Listen for 'Enter' key press in the input field
                KTUtil.on(element, '[data-kt-element="input"]', 'keydown', function(event) {
                    if (event.keyCode === 13) {
                        ChatApp.handleMessaging(element);
                        event.preventDefault();
                    }
                });
                // Listen for 'Send' button click
                KTUtil.on(element, '[data-kt-element="send"]', 'click', function() {
                    ChatApp.handleMessaging(element);
                });
            }

            // Handles the messaging logic when a message is sent
            static handleMessaging(element) {

                sendChatMessage(element);

            }

            // Initialize chat functionality on a given element
            static init(element) {
                ChatApp.handleSend(element);
            }
        }

        // Initialize chat functionality for inline messenger
        KTUtil.onDOMContentLoaded(function() {
            ChatApp.init(document.querySelector('#kt_chat_messenger'));
            var scrollContainer = document.getElementById('messageScroll');
            scrollContainer.scrollTop = scrollContainer.scrollHeight;
        });




        function sendChatMessage(element) {

            var message = element.querySelector('[data-kt-element="input"]').value;
            var sendTextButtonElement = document.getElementById("sentTextButton");
            sendTextButtonElement.classList.add("disabled");

            // Create a new XMLHttpRequest object
            var xhr = new XMLHttpRequest();

            // Configure the GET request
            var url = "{{route('exchange.transactions.receive.message')}}";
            url = url + "?ex_trans_id="+{{$exchangeTransaction->id}}+"&message="+message;
            xhr.open("GET", url, true);

            xhr.setRequestHeader("Accept", "application/json");

            // Set up a function to handle the response
            xhr.onload = function () {

                var responseData = JSON.parse(xhr.responseText);

                if (xhr.status === 200 && responseData.status === 200) {
                    // Request was successful, handle the response here
                    // console.log("Response Data:", responseData);
                    sendTextToChat(element);
                } else {
                    // Request encountered an error
                    // console.error("Request failed with status:", responseData.message);
                    toastr.error(responseData.message);
                }

                sendTextButtonElement.classList.remove("disabled");
            };

            // Set up a function to handle errors
            xhr.onerror = function () {
                toastr.error("Network Error Occurred");
                console.error("Network error occurred");
            };

            // Send the GET request
            xhr.send();

        }

        function sendTextToChat(element) {
            const messages = element.querySelector('[data-kt-element="messages"]');
            const input = element.querySelector('[data-kt-element="input"]');

            // Do nothing if the input is empty
            if (input.value.length === 0) {
                return;
            }

            // Clone outgoing message template, update text, and append to messages
            var theText = input.value;
            const messageOutTemplate = messages.querySelector('[data-kt-element="template-out"]');
            const outgoingMessage = messageOutTemplate.cloneNode(true);
            outgoingMessage.classList.remove('d-none');
            outgoingMessage.querySelector('[data-kt-element="message-text"]').innerText = theText;
            input.value = '';
            messages.appendChild(outgoingMessage);
            messages.scrollTop = messages.scrollHeight;
        }

        function addIncomingMessage(element,senderInitial,sender,createdAt,theText){
            const messages = element.querySelector('[data-kt-element="messages"]');

            // Clone incoming message template, update text, and append to messages
            const messageOutTemplate = messages.querySelector('[data-kt-element="template-in"]');
            const incomingMessage = messageOutTemplate.cloneNode(true);
            incomingMessage.classList.remove('d-none');
            incomingMessage.querySelector('[data-kt-element="message-sender-initial"]').innerText = senderInitial;
            incomingMessage.querySelector('[data-kt-element="message-sender"]').innerText = sender;
            incomingMessage.querySelector('[data-kt-element="message-created-at"]').innerText = createdAt;
            incomingMessage.querySelector('[data-kt-element="message-text"]').innerText = theText;
            messages.appendChild(incomingMessage);
            messages.scrollTop = messages.scrollHeight;
        }

    </script>


    <script>

        //ACCOUNT NAME - CLIPBOARD
        const targetAcName = document.getElementById('kt_clipboard_acname');
        const acNameButton = targetAcName.nextElementSibling;
        var acNameClipboard = new ClipboardJS(acNameButton, {
            target: targetAcName,
            text: function() {
                return targetAcName.value;
            }
        });
        acNameClipboard.on('success', function(e) {
            const currentLabel = acNameButton.innerHTML;
            if(acNameButton.innerHTML === 'Copied!'){
                return;
            }
            acNameButton.innerHTML = 'Copied!';
            setTimeout(function(){
                acNameButton.innerHTML = currentLabel;
            }, 3000)
        });
        //END:: ACCOUNT NAME - CLIPBOARD

        //ACCOUNT NUMBER - CLIPBOARD
        const targetAcNumber = document.getElementById('kt_clipboard_acnumber');
        const acNumberButton = targetAcNumber.nextElementSibling;
        var acNumberClipboard = new ClipboardJS(acNumberButton, {
            target: targetAcNumber,
            text: function() {
                return targetAcNumber.value;
            }
        });
        acNumberClipboard.on('success', function(e) {
            const currentLabel = acNumberButton.innerHTML;
            if(acNumberButton.innerHTML === 'Copied!'){
                return;
            }
            acNumberButton.innerHTML = 'Copied!';
            setTimeout(function(){
                acNumberButton.innerHTML = currentLabel;
            }, 3000)
        });
        //END:: ACCOUNT NUMBER - CLIPBOARD

    </script>

@endsection
