@once
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/admin/trix.css') }}">
        <link rel="stylesheet" href="{{ asset('css/trix/custom-trix.min.css') }}">
    @endpush

    @push('js')
        <script src="{{ asset('js/admin/trix.js') }}"></script>
    @endpush
@endonce

<div x-data="{ trix: @entangle("$comment").defer }">
    <input id="{{ $comment }}" name="{{ $comment }}" type="hidden"/>
    <div wire:ignore
        x-on:trix-change.debounce.500ms="trix = $refs.trixInput.value">
        <trix-editor x-ref="trixInput" input="{{ $comment }}" class="trix-editor border-gray-300 trix-content"></trix-editor>
    </div>
</div>