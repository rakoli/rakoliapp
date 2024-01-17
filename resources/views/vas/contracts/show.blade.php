@extends('layouts.users.vas')

@section('title', __("Contract Detail"))

@section('content')
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">

        <!--begin::Layout-->
        <div class="d-flex flex-column flex-xl-row">

            <!--begin::Sidebar-->
            <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
                <!--begin::Card-->
                <div class="card mb-5 mb-xl-8">
                    <!--begin::Card body-->
                    <div class="card-body pt-5">
                        <!--begin::Details content-->
                        <div class="collapse show">
                            <div class="py-5 fs-6">

                                <!--begin::Details item-->
                                <div class="fw-bold mt-5">{{__("Business")}}</div>
                                <div class="text-gray-600">{{$contract->business->business_name}}</div>
                                <!--begin::Details item-->
                                <div class="fw-bold mt-5">{{__("Agent")}}</div>
                                <div class="text-gray-600">{{$contract->agent->business_name}}</div>
                                <div class="fw-bold mt-5">{{__("Title")}}</div>
                                <div class="text-gray-600">{{$contract->title}}</div>
                                <div class="fw-bold mt-5">{{__("Task Code")}}</div>
                                <div class="text-gray-600">{{$contract->vas_task_code}}</div>
                                <!--begin::Details item-->
                                <div class="fw-bold mt-5">{{__("Duration")}}</div>
                                <div class="text-gray-600">
                                    <div class="text-gray-600">
                                        {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $contract->time_start)->format('d.m.Y h:i a') }}
                                        @if(!empty($contract->time_end))
                                         To {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $contract->time_end)->format('d.m.Y h:i a') }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Details content-->
                    </div>
                    <!--end::Card body-->
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
                                        Chat
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
                            <a class="btn btn-secondary" href="{{route('vas.contracts.index')}}">{{__('Go Back')}}</a>
                            <button id="sentTextButton" class="btn btn-primary" type="button" data-kt-element="send">{{__('Send')}}</button>
                            <!--end::Send-->
                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Card footer-->
                </div>
                <!--end::Messenger-->
            </div>
            <!--end::Content-->

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
@endsection
