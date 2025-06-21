<!--begin::Form-->
<form id="kt_form" class="form d-flex flex-column flex-lg-row" data-kt-redirect="{{route('admin.system.send-message')}}" action="{{$submitUrl}}" method="post">
    @csrf
    <!--begin::Aside column-->
    <!--end::Aside column-->
    <!--begin::Main column-->
    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">

        <!--begin::Pricing-->
        <div class="card card-flush py-4">
            <!--begin::Card header-->
            <div class="card-header">
                <div class="card-title">
                    <h2>{{__("Send Message")}}</h2>
                </div>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">

                <div class="mb-5 fv-row">
                    <!--end::Label-->
                    <label class="form-label">{{__('User')}}</label>
                    <!--begin::Input-->
                    <select data-control="select2" data-hide-search="true" data-placeholder="Select a User..." class="form-select form-select-solid" name="users[]" multiple>
                        @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->fname}} {{$user->lname}}</option>
                        @endforeach
                    </select>
                    <!--end::Input-->
                </div>

                <div class="mb-5 fv-row">
                    <!--end::Label-->
                    <label class="form-label">{{__('Message')}}</label>
                    <!--begin::Input-->
                    <textarea type="text" class="form-control mb-2" id="message" name="message" placeholder="{{__("Type your message")}}"  required></textarea>
                </div>
            </div>
            <!--end::Card header-->
        </div>
        <!--end::Pricing-->

        <div class="d-flex justify-content-end">
            <button type="submit" id="submit_button" class="btn btn-primary">
                <span class="indicator-label">{{__('Send')}}</span>
                <span class="indicator-progress">{{__('Please wait...')}}
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
    </div>
    <!--end::Main column-->
</form>
<!--end::Form-->
