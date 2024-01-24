@props([
    'id',
    'name',
])
<input type="text" class="form-control" name="{{ $name }}" id="{{ $id }}">


@push('js')
    <script>
        $(document).ready(() => {

            $("#{{ $id }}").flatpickr({
                maxDate: new Date()
            });
        });
    </script>
@endpush
