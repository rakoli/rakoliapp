@extends('layouts.auth_basic')

@section('title', __('Reset Password'))

@section('banner_image_url', '')

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

            <form method="POST" action="{{ route('changepassword.submit') }}">
                @csrf

                <!--begin::Heading-->
                <div class="text-center mb-10">
                    <!--begin::Title-->
                    <h1 class="text-dark fw-bolder mb-3">{{ __("Change Password")}}</h1>
                    <!--end::Title-->
                </div>
                <!--begin::Heading-->

                <div class="fv-row mb-8">
                    <input id="current_password" type="password" placeholder="{{ __("Current Password")}}" class="form-control bg-transparent @error('current_password') is-invalid @enderror" name="current_password" required>
                </div>

                <div class="fv-row mb-8">
                    <input id="password" type="password" placeholder="{{ __("Password")}}" class="form-control bg-transparent @error('password') is-invalid @enderror" name="password" required >
                    <!--begin::Hint-->
                    <div class="text-muted">{{ __("Use 8 or more characters with a mix of letters, numbers & symbols.")}}</div>
                    <!--end::Hint-->
                </div>

                <div class="fv-row mb-8">
                    <input id="password-confirm" type="password" placeholder="{{ __("Repeat Password")}}" class="form-control bg-transparent" name="password_confirmation" required>
                </div>


                <div class="d-grid mb-10">
                    <button type="submit" class="btn btn-primary">
                        <!--begin::Indicator label-->
                        <span class="indicator-label">{{ __("Submit")}}</span>
                        <!--end::Indicator label-->
                        <!--begin::Indicator progress-->
                        <span class="indicator-progress">
                            {{ __("Please wait...")}}
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                        <!--end::Indicator progress-->
                    </button>

                    <!--begin::Button-->
                    <a href="{{route('home')}}" class="btn btn-secondary mt-5">{{__("Cancel")}}</a>
                    <!--end::Button-->
                </div>

            </form>

        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Form-->

@endsection

@section('js')

@endsection
