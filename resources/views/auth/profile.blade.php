@extends('layouts.auth_basic')

@section('title', __('Profile'))

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

            <form method="POST" action="{{ route('profile.submit') }}">
                @csrf

                <!--begin::Heading-->
                <div class="text-center mb-10">
                    <!--begin::Title-->
                    <h1 class="text-dark fw-bolder mb-3">{{ __("User Profile")}}</h1>
                    <!--end::Title-->
                </div>
                <!--begin::Heading-->

                <div class="fv-row mb-8">
                    <label for="fname" class="form-label">{{__('First Name')}}</label>
                    <input id="fname" name="fname" type="text" value="{{$user->fname}}" class="form-control bg-transparent @error('current_password') is-invalid @enderror" required>
                </div>

                <div class="fv-row mb-8">
                    <label for="lname" class="form-label">{{__('Last Name')}}</label>
                    <input id="lname" name="lname" type="text" value="{{$user->lname}}" class="form-control bg-transparent @error('current_password') is-invalid @enderror" required>
                </div>

                <div class="fv-row mb-8">
                    <label for="fname" class="form-label">{{__('Email')}}</label>
                    <input id="email" name="email" type="email" value="{{$user->email}}" class="form-control bg-transparent @error('current_password') is-invalid @enderror"
                           @if($user->email_verified_at != null)
                               disabled
                           @endif
                           required>

                    @if($user->email_verified_at != null)
                        <div class="text-muted">{{ __("Contact Support to Change Verified Email") }}</div>
                    @endif

                </div>

                <div class="fv-row mb-8">
                    <label for="fname" class="form-label">{{__('Phone')}}</label>
                    <input id="phone" name="phone" type="text" value="{{$user->phone}}" class="form-control bg-transparent @error('current_password') is-invalid @enderror"
                           @if($user->phone_verified_at != null)
                                disabled
                           @endif
                           required>
                    @if($user->phone_verified_at != null)
                        <div class="text-muted">{{ __("Contact Support to Change Verified Phone") }}</div>
                    @endif
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
