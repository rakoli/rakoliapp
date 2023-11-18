<!--begin::Modal group-->
<div class="modal fade" tabindex="-1" id="edit_contact_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{__("Edit Contact")}}</h3>
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <p>{{__("Modify your submitted contact information")}}</p>

                <form class="my-auto pb-5" action="{{route('edit.contact.information')}}" method="POST">

                    @csrf

                    <!--begin::Input group-->
                    <div class="row mb-5">
                        <div class="input-group input-group-lg mb-5">
                            <span class="input-group-text" id="basic-addon1">{{__("Email")}}</span>
                            <input @if(auth()->user()->email_verified_at != null) disabled @endif name="email" type="email" class="form-control" value="@if(auth()->user()->email_verified_at != null) {{__("EMAIL ALREADY VERIFIED")}} @else{{auth()->user()->email}}@endif"/>
                        </div>

                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row">
                        <div class="input-group input-group-lg mb-5">
                            <span class="input-group-text" id="basic-addon1">{{__("Phone")}}</span>
                            <input @if(auth()->user()->phone_verified_at != null) disabled @endif name="phone" type="text" class="form-control" value="@if(auth()->user()->phone_verified_at != null) {{__("PHONE ALREADY VERIFIED")}} @else{{auth()->user()->phone}}@endif"/>
                            <div class="text-muted fw-semibold fs-6">{{__("Enter phone number using format above starting with country code without + sign e.g 255763987654")}}</div>
                        </div>
                    </div>
                    <!--end::Input group-->

                    @if(!(auth()->user()->phone_verified_at != null && auth()->user()->email_verified_at != null))
                        <button type="submit" class="btn btn-primary">{{__("Edit Information")}}</button>
                    @endif

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__("Close")}}</button>
            </div>
        </div>
    </div>
</div>
<!--end::Modal group-->
