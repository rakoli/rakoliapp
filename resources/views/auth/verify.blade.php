@extends('layouts.auth_basic')

@section('title', __('Verify ID'))

@section('banner_image_url', '')

@section('header_js')
    <script src='https://cdn.veriff.me/sdk/js/1.5/veriff.min.js'></script>
    <script src='https://cdn.veriff.me/incontext/js/v1/veriff.js'></script>
@endsection

@section('body')

    @if ($errors->any())
        <!--begin::Container-->
        <div class="container-xxl mb-5">
            <div class="card card-flush mb-0">
                <div class="alert alert-danger mb-0">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @if(session('message'))
        <div class="container-xxl mb-5">
            <div class="card card-flush mb-0">
                <div class="alert alert-success mb-0">
                    {{ session('message') }}
                </div>
            </div>
        </div>
    @endif

    <!--begin::Form-->
    <div class="d-flex flex-center flex-column flex-lg-row-fluid">
        <!--begin::Wrapper-->
        <div class="w-lg-500px p-10">

            <div id='veriff-root' style="width:400px"></div>


        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Form-->

@endsection

@section('js')
    <script>
        const veriff = Veriff({
            host: 'https://stationapi.veriff.com',
            apiKey: '457d42a3-742e-4270-afcc-3c56e959537e',
            parentId: 'veriff-root',
            onSession: function(err, response) {
                console.log("ERROR");
                console.log(err);
                console.log("Reponse")
                console.log(response)
                window.veriffSDK.createVeriffFrame({ url: response.verification.url });
                console.log("Session ID")
                console.log(response.verification.id)
            },
            onEvent: function(msg) {
                console.log("MESSAGE")
                console.log(msg)
                // switch(msg) {
                //     case MESSAGES.STARTED:
                //         console.log("STARTED")
                //         console.log(MESSAGES.STARTED)
                //
                //         break;
                //     case MESSAGES.CANCELED:
                //         console.log("CANCELLED")
                //         console.log(MESSAGES.STARTED)
                //
                //         break;
                //     case MESSAGES.FINISHED:
                //         console.log("FINISHED")
                //         console.log(MESSAGES.FINISHED)
                //
                //
                //         //
                //         break;
                // }
            }
        });

        // const url = sessionStorage.getItem('@veriff-session-url') || getSessionUrl()
        // veriffSDK.createVeriffFrame({
        //     url,
        //     onReload: () => {
        //         // Logic to re-open Veriff SDK after page reload
        //         // e.g. sessionStorage.setItem('@veriff-session-url', url);
        //         window.location.reload();
        //     },
        // });


        veriff.setParams({
            person: {
                givenName: 'Erick',
                lastName: 'Mabusi'
            },
            vendorData: '199233830-333-222-1122'
        });

        veriff.mount();
    </script>
@endsection
