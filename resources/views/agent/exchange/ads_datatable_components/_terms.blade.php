<div class="d-flex flex-column justify-content-center w-210px">
    <div class="fs-6 flex-wrap text-gray-600">
        {{\Illuminate\Support\Str::limit($ad->description,100)}}
    </div>
    <div class="fw-semibold text-gray-600"><i class="ki-solid ki-pin fs-6"></i> {{\Illuminate\Support\Str::limit($ad->availability_desc,33)}}</div>
</div>
