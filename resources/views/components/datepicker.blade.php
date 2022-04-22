@php
    $datePickerId = uniqid();
@endphp
<div class="margin-bottom-sm">
    <div class="grid gap-xxs">
      <div class="col-3@lg">
        <label class="inline-block text-sm padding-top-xs@lg" for="created_at">Дата</label>
      </div>

      <div class="col-6@lg">
        <input class="form-control" type="text" id="datepicker{{ $datePickerId }}" name="created_at" value="{{ $date }}">
      </div>
    </div>
 </div>

 @push('js')
    <script>
        var picker = new Pikaday({
            field: document.getElementById('datepicker{{ $datePickerId }}'),
            // format: 'DD/MM/YYYY HH:mm:ss',
            format: 'YYYY-MM-DD HH:mm:ss',
        });
    </script>
@endpush

@once
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/admin/pikaday.css') }}">
    @endpush

    @prepend('js')
        <script src="{{ asset('js/admin/moment.min.js') }}"></script>
        <script src="{{ asset('js/admin/pikaday.js') }}"></script>
    @endprepend
@endonce