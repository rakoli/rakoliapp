@extends('layouts.users.vas')

@section('title', __("Create Task"))

@section('content')

    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">

        @include('vas.opportunities._submenu')

        @include('vas.opportunities.tasks._form', ['submitUrl'=>route('vas.tasks.store'),'isEdit'=>false])

    </div>
    <!--end::Container-->

@endsection

@section('footer_js')
    @include('vas.opportunities.tasks._form_js')
<script>
    jQuery(document).ready(function(){
        jQuery("#private_agents").select2({
            minimumInputLength: 3,
            ajax: {
                url: '{!! route("get.agents") !!}',
                data: function (params) {
                var query = {
                    search: params.term,
                }
                return query;
                },
                processResults: function (data) {
                // Transforms the top-level key of the response object from 'items' to 'results'
                data = data.data;
                return {
                    results: data.map(({business_code, fname, lname}) => ({id: business_code, text: fname+" "+lname}))
                };
                }
            }
        })
    });
</script>
@endsection
