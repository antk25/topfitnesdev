
<div
    x-data="{ value: @entangle($attributes->wire('model')) }"
    x-on:change="value = $event.target.value"
    x-init="new Pikaday({ field: $refs.input, format: 'YYYY-MM-DD HH:mm:ss' });">
    <div class="relative mt-2">
        <input
            class="form-control"
            x-ref="input"
            x-bind:value="value"
            type="text"
            placeholder="Выбрать дату"
        />
     </div>
</div>

@once
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/admin/pikaday.css') }}">
    @endpush

    @prepend('js')
        <script src="{{ asset('js/admin/moment.min.js') }}"></script>
        <script src="{{ asset('js/admin/pikaday.js') }}"></script>
    @endprepend
@endonce