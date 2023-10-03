@extends('layouts.app')

@section('content')

<!--begin::Main column-->
<div class="d-flex flex-column flex-lg-row-fluid gap-7 gap-lg-10">
    <!--begin::Order details-->
        
    <form class="form w-100"  action="/admin/register">
    <!--end::Order details-->
    <!--begin::Order details-->
    <div class="card card-flush py-4">
        <!--begin::Card header-->
        <div class="card-header">
            <div class="card-title">
                <h2>Create User</h2>
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
             
            <!--begin::Input group=-->
            <div class="fv-row mb-8">
                <div class="d-flex flex-column flex-md-row gap-5">
                    <div class="fv-row flex-row-fluid">
                        <input required type="text" placeholder="{{ $translator("First Name", "Jina la Kwanza") }}" name="first-name" autocomplete="off" class="form-control bg-transparent" />
                    </div>
                    <div class="fv-row flex-row-fluid">
                        <input required type="text" placeholder="{{ $translator("Last Name", "Jina la Mwisho") }}" name="last-name" autocomplete="off" class="form-control bg-transparent" />
                    </div>
                </div>
            </div>

            <div class="fv-row mb-8">
                <div class="d-flex flex-column flex-md-row gap-5">
                    <div class="flex-row-fluid">
                        <!--begin::Input-->
                        <select class="form-control" name="type">
                            <option value="">{{ $translator("User category", "Aina ya mtumiaji") }}</option>
                            <option value="admin">Admin</option>
                            <option value="vas">VAS Provider</option>
                            <option value="agent">Agent</option>
                        </select>
                        <!--end::Input-->
                    </div>
                    <div class="flex-row-fluid">
                        <!--begin::Input-->
                        <select  id="countrySelect" class="form-control" name="country">
                            <option value="">{{ $translator("User Country", "Nchi yake") }}</option>
                            <option value="+254">(+254) Kenya</option>
                            <option value="+255">(+255) Tanzania</option>
                            <option value="+256">(+256) Uganda</option>
                        </select>
                        <!--end::Input-->
                    </div>
                     
                    <div class="fv-row flex-row-fluid">
                        <!--begin::Input-->
                        <input required class="form-control" name="phone" placeholder="07XX..." value="" />
                        <!--end::Input-->
                    </div>
                </div>
            </div>
            <div class="fv-row mb-8">
                <!--begin::Email-->
                <input required type="email" placeholder="{{ $translator("Email", "Barua pepe") }}" name="email" autocomplete="off" class="form-control bg-transparent" />
                <!--end::Email-->
            </div>
            <!--begin::Input group-->
            <div class="fv-row mb-8" data-kt-password-meter="true">
                <!--begin::Wrapper-->
                <div class="mb-1">
                    <!--begin::Input wrapper-->
                    <div class="position-relative mb-3">
                        <input required class="form-control bg-transparent" type="password" placeholder="{{ $translator("Password", "Nenosiri") }}" name="password" autocomplete="off" />
                        <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                            <i class="ki-outline ki-eye-slash fs-2"></i>
                            <i class="ki-outline ki-eye fs-2 d-none"></i>
                        </span>
                    </div>
                    <!--end::Input wrapper-->
                    <!--begin::Meter-->
                    <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                    </div>
                    <!--end::Meter-->
                </div>
                <!--end::Wrapper-->
                <!--begin::Hint-->
                <div class="text-muted">{{ $translator("Use 8 or more characters with a mix of letters, numbers & symbols.", "Tumia herufi 8 au zaidi na mchanganyiko wa herufi, nambari, na alama.") }}</div>
                <!--end::Hint-->
            </div>
            <!--end::Input group=-->
            <!--end::Input group=-->
            <div class="fv-row mb-8">
                <!--begin::Repeat Password-->
                <input required placeholder="{{ $translator("Repeat Password", "Rekebisha Nenosiri") }}" name="confirm-password" type="password" autocomplete="off" class="form-control bg-transparent" />
                <!--end::Repeat Password-->
            </div>
            <!--end::Input group=-->
            <!--begin::Accept-->
             
            <!--end::Accept-->
            <!--begin::Submit button-->
            <div class="d-grid mb-10">
                <button type="submit" id="kt_sign_up_submit" class="btn btn-primary">
                    <!--begin::Indicator label-->
                    <span class="indicator-label">{{ $translator("Sign up", "Jiandikishe") }}</span>
                    <!--end::Indicator label-->
                    <!--begin::Indicator progress-->
                    <span class="indicator-progress">{{ $translator("Please wait...", "Tafadhali subiri...") }}
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    <!--end::Indicator progress-->
                </button>
            </div>
            <!--end::Submit button-->
           
              
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Order details-->
    
    </form>
</div>
<!--end::Main column-->

@endsection

