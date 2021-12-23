<div>
    @if ($model->reviews->count())
    <div class="margin-y-sm text-component">
        <h2>{{ $model->reviews->count() }} {{ trans_choice('отзыв|отзыва|отзывов', $model->reviews->count()) }}</h2>
    </div>
    <p class="cd-demo-margin-bottom-md cd-demo-text-center">👇 <a href="#toc5">Написать отзыв</a></p>
    @foreach ($model->reviews as $review)
    @include('livewire.reviews.show2')
    @endforeach
    @endif
    @section('style')
        @parent
            <link rel="stylesheet" href="{{ asset('css/admin/trix.css') }}">
            <style>
                trix-toolbar {
    position: sticky;
    top: 0;
    z-index: 10;
    background-color: #fff;
    border: 0 !important;
    border-top-right-radius: 0.5em;
    border-top-left-radius: 0.5em;
    padding: 0.5em;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    margin-left: 1px;
    margin-right: 1px;
    margin-top: 0.5em;
}
.trix-editor {
    margin-top: -2.8em;
    padding-top: 4em;
}
trix-toolbar .trix-button-group {
    /* border-color: #ddd;
    border-bottom-color: #ccc; */
    overflow: hidden;
    border-radius: 4px;
    margin-bottom: 0;
    border: 0;
}
trix-toolbar .trix-button:not(:first-child) {
    border-left: 0;
}
trix-toolbar .trix-button {
    border: 0;
    background-color: #fff;
}
trix-toolbar .trix-button--icon::before {
    opacity: 0.75;
}
trix-toolbar .trix-button--icon-bold::before {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-bold' width='44' height='44' viewBox='0 0 24 24' stroke-width='1.5' stroke='%232c3e50' fill='none' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath stroke='none' d='M0 0h24v24H0z'/%3E%3Cpath d='M7 5h6a3.5 3.5 0 0 1 0 7h-6z' /%3E%3Cpath d='M13 12h1a3.5 3.5 0 0 1 0 7h-7v-7' /%3E%3C/svg%3E");
}

trix-toolbar .trix-button--icon-italic::before {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-italic' width='44' height='44' viewBox='0 0 24 24' stroke-width='1.5' stroke='%232c3e50' fill='none' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath stroke='none' d='M0 0h24v24H0z'/%3E%3Cline x1='11' y1='5' x2='17' y2='5' /%3E%3Cline x1='7' y1='19' x2='13' y2='19' /%3E%3Cline x1='14' y1='5' x2='10' y2='19' /%3E%3C/svg%3E");
}
trix-toolbar .trix-button--icon-strike::before {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-strikethrough' width='44' height='44' viewBox='0 0 24 24' stroke-width='1.5' stroke='%232c3e50' fill='none' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath stroke='none' d='M0 0h24v24H0z'/%3E%3Cline x1='5' y1='12' x2='19' y2='12' /%3E%3Cpath d='M16 6.5a4 2 0 0 0 -4 -1.5h-1a3.5 3.5 0 0 0 0 7' /%3E%3Cpath d='M16.5 16a3.5 3.5 0 0 1 -3.5 3h-1.5a4 2 0 0 1 -4 -1.5' /%3E%3C/svg%3E");
}

trix-toolbar .trix-button--icon-code::before {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-code' width='44' height='44' viewBox='0 0 24 24' stroke-width='1.5' stroke='%232c3e50' fill='none' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath stroke='none' d='M0 0h24v24H0z'/%3E%3Cpolyline points='7 8 3 12 7 16' /%3E%3Cpolyline points='17 8 21 12 17 16' /%3E%3Cline x1='14' y1='4' x2='10' y2='20' /%3E%3C/svg%3E");
}

trix-toolbar .trix-button--icon-link::before {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-link' width='44' height='44' viewBox='0 0 24 24' stroke-width='1.5' stroke='%232c3e50' fill='none' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath stroke='none' d='M0 0h24v24H0z'/%3E%3Cpath d='M10 14a3.5 3.5 0 0 0 5 0l4 -4a3.5 3.5 0 0 0 -5 -5l-.5 .5' /%3E%3Cpath d='M14 10a3.5 3.5 0 0 0 -5 0l-4 4a3.5 3.5 0 0 0 5 5l.5 -.5' /%3E%3C/svg%3E");
}

trix-toolbar .trix-button--icon-bullet-list::before {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-list' width='44' height='44' viewBox='0 0 24 24' stroke-width='1.5' stroke='%232c3e50' fill='none' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath stroke='none' d='M0 0h24v24H0z'/%3E%3Cline x1='9' y1='6' x2='20' y2='6' /%3E%3Cline x1='9' y1='12' x2='20' y2='12' /%3E%3Cline x1='9' y1='18' x2='20' y2='18' /%3E%3Cline x1='5' y1='6' x2='5' y2='6.01' /%3E%3Cline x1='5' y1='12' x2='5' y2='12.01' /%3E%3Cline x1='5' y1='18' x2='5' y2='18.01' /%3E%3C/svg%3E");
}

trix-toolbar .trix-button--icon-decrease-nesting-level::before {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-indent-decrease' width='44' height='44' viewBox='0 0 24 24' stroke-width='1.5' stroke='%232c3e50' fill='none' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath stroke='none' d='M0 0h24v24H0z'/%3E%3Cline x1='20' y1='6' x2='13' y2='6' /%3E%3Cline x1='20' y1='12' x2='11' y2='12' /%3E%3Cline x1='20' y1='18' x2='13' y2='18' /%3E%3Cpath d='M8 8l-4 4l4 4' /%3E%3C/svg%3E");
}

trix-toolbar .trix-button--icon-increase-nesting-level::before {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-indent-increase' width='44' height='44' viewBox='0 0 24 24' stroke-width='1.5' stroke='%232c3e50' fill='none' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath stroke='none' d='M0 0h24v24H0z'/%3E%3Cline x1='20' y1='6' x2='9' y2='6' /%3E%3Cline x1='20' y1='12' x2='13' y2='12' /%3E%3Cline x1='20' y1='18' x2='9' y2='18' /%3E%3Cpath d='M4 8l4 4l-4 4' /%3E%3C/svg%3E");
}

trix-toolbar .trix-button--icon-attach::before {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-photo' width='44' height='44' viewBox='0 0 24 24' stroke-width='1.5' stroke='%232c3e50' fill='none' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath stroke='none' d='M0 0h24v24H0z'/%3E%3Cline x1='15' y1='8' x2='15.01' y2='8' /%3E%3Crect x='4' y='4' width='16' height='16' rx='3' /%3E%3Cpath d='M4 15l4 -4a3 5 0 0 1 3 0l 5 5' /%3E%3Cpath d='M14 14l1 -1a3 5 0 0 1 3 0l 2 2' /%3E%3C/svg%3E");
}

trix-toolbar .trix-button--icon-quote::before {
    background-image: url("data:image/svg+xml,%3Csvg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-blockquote-left' fill='%232c3e50' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath fill-rule='evenodd' d='M2 3.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm5 3a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm-5 3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z'/%3E%3Cpath d='M3.734 6.352a6.586 6.586 0 0 0-.445.275 1.94 1.94 0 0 0-.346.299 1.38 1.38 0 0 0-.252.369c-.058.129-.1.295-.123.498h.282c.242 0 .431.06.568.182.14.117.21.29.21.521a.697.697 0 0 1-.187.463c-.12.14-.289.21-.503.21-.336 0-.577-.108-.721-.327C2.072 8.619 2 8.328 2 7.969c0-.254.055-.485.164-.692.11-.21.242-.398.398-.562.16-.168.33-.31.51-.428.18-.117.33-.213.451-.287l.211.352zm2.168 0a6.588 6.588 0 0 0-.445.275 1.94 1.94 0 0 0-.346.299c-.113.12-.199.246-.257.375a1.75 1.75 0 0 0-.118.492h.282c.242 0 .431.06.568.182.14.117.21.29.21.521a.697.697 0 0 1-.187.463c-.12.14-.289.21-.504.21-.335 0-.576-.108-.72-.327-.145-.223-.217-.514-.217-.873 0-.254.055-.485.164-.692.11-.21.242-.398.398-.562.16-.168.33-.31.51-.428.18-.117.33-.213.451-.287l.211.352z'/%3E%3C/svg%3E");
}
trix-toolbar .trix-button--icon-number-list::before {
    background-image: url("data:image/svg+xml,%3Csvg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-list-ol' fill='%232c3e50' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath fill-rule='evenodd' d='M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5z'/%3E%3Cpath d='M1.713 11.865v-.474H2c.217 0 .363-.137.363-.317 0-.185-.158-.31-.361-.31-.223 0-.367.152-.373.31h-.59c.016-.467.373-.787.986-.787.588-.002.954.291.957.703a.595.595 0 0 1-.492.594v.033a.615.615 0 0 1 .569.631c.003.533-.502.8-1.051.8-.656 0-1-.37-1.008-.794h.582c.008.178.186.306.422.309.254 0 .424-.145.422-.35-.002-.195-.155-.348-.414-.348h-.3zm-.004-4.699h-.604v-.035c0-.408.295-.844.958-.844.583 0 .96.326.96.756 0 .389-.257.617-.476.848l-.537.572v.03h1.054V9H1.143v-.395l.957-.99c.138-.142.293-.304.293-.508 0-.18-.147-.32-.342-.32a.33.33 0 0 0-.342.338v.041zM2.564 5h-.635V2.924h-.031l-.598.42v-.567l.629-.443h.635V5z'/%3E%3C/svg%3E");
}

trix-toolbar .trix-button--icon-undo::before {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-arrow-back-up' width='44' height='44' viewBox='0 0 24 24' stroke-width='1.5' stroke='%232c3e50' fill='none' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath stroke='none' d='M0 0h24v24H0z'/%3E%3Cpath d='M9 13l-4 -4l4 -4m-4 4h11a4 4 0 0 1 0 8h-1' /%3E%3C/svg%3E");
}

trix-toolbar .trix-button--icon-redo::before {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-arrow-forward-up' width='44' height='44' viewBox='0 0 24 24' stroke-width='1.5' stroke='%232c3e50' fill='none' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath stroke='none' d='M0 0h24v24H0z'/%3E%3Cpath d='M15 13l4 -4l-4 -4m4 4h-11a4 4 0 0 0 0 8h1' /%3E%3C/svg%3E");
}

trix-toolbar .trix-button--icon-heading-1::before {
    background-image: url("data:image/svg+xml,%3Csvg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-type-h1' fill='%232c3e50' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M8.637 13V3.669H7.379V7.62H2.758V3.67H1.5V13h1.258V8.728h4.62V13h1.259zm5.329 0V3.669h-1.244L10.5 5.316v1.265l2.16-1.565h.062V13h1.244z'/%3E%3C/svg%3E");
}

trix-editor:empty:not(:focus)::before {
    color: #a0aec0;
}

.trix-content h1 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.75rem;
}

.trix-content a {
    text-decoration: underline;
    cursor: pointer;
    color: #667eea;
}

.trix-content blockquote {
    border-left-color: #667eea;
}

.trix-content pre {
    border-radius: 0.5em;
}

.trix-content ol,
.trix-content ul {
    margin-bottom: 1rem;
}

.trix-content li {
    position: relative;
    padding-left: 1.5em;
    margin-bottom: 1rem;
}
.trix-content ul li:before {
    position: absolute;
    top: 10px;
    left: 0;
    content: "";
    width: 0.4em;
    height: 0.4em;
    background-color: #667eea;
    border-radius: 50%;
    display: inline-block;
}

.trix-content ol {
    counter-reset: custom-counter;
}
.trix-content ol li:before {
    counter-increment: custom-counter;
    position: absolute;
    top: 2px;
    left: 0;
    content: counter(custom-counter) ".";
    display: inline-block;
    font-size: 0.85em;
    font-weight: 500;
    color: #667eea;
    text-align: right;
}

.markdown-content {
    max-width: 65ch; // change according to need...
}
.markdown-content pre code {
    padding: 1rem;
    font-size: 0.9rem;
}
.markdown-content div,
.markdown-content p,
.markdown-content pre,
.markdown-content blockquote,
.markdown-content ol,
.markdown-content ul {
    margin-bottom: 1.5rem;
}
.markdown-content h1,
.markdown-content h2,
.markdown-content h3 {
    color: #1a202c;
    font-size: 2rem;
    font-weight: bold;
    margin-top: 0;
    margin-bottom: 0.75rem;
    line-height: 1.2;
}
.markdown-content strong {
    font-weight: bold;
}
.markdown-content blockquote {
    display: block;
    border-left: 4px solid #667eea;
    padding-left: 0.8em;
    font-size: 1.25rem;
    font-style: italic;
    font-weight: 400;
}
.markdown-content a {
    color: #667eea;
    text-decoration: underline;
    text-decoration-color: hsla(229,76%,66%, 0.3);
    -moz-text-decoration-color: hsla(229,76%,66%, 0.3);
}
.markdown-content a:hover {
    text-decoration-color: hsla(229,76%,66%, 1);
    -moz-text-decoration-color: hsla(229,76%,66%,1);
}

.markdown-content ol,
.markdown-content ul {
    display: block;
}

.markdown-content li {
    position: relative;
    padding-left: 1.5em;
    margin-bottom: 1rem;
}
.markdown-content ul li:before {
    position: absolute;
    top: 10px;
    left: 0;
    content: "";
    width: 0.4em;
    height: 0.4em;
    background-color: #667eea;
    border-radius: 50%;
    display: inline-block;
}

.markdown-content ol {
    counter-reset: custom-counter;
}
.markdown-content ol li:before {
    counter-increment: custom-counter;
    position: absolute;
    top: 2px;
    left: 0;
    content: counter(custom-counter) ".";
    display: inline-block;
    font-size: 0.85em;
    font-weight: 500;
    color: #667eea;
    text-align: right;
}
            </style>

    @endsection
    @section('footerScripts')
        @parent
        <script src="{{ asset('js/admin/trix.js') }}"></script>
    @endsection
        <form wire:submit.prevent="store()">

        <div class="emoji-rate bg radius-md">
            <div class="padding-md text-center">
                <p class="margin-bottom-xs">Написать отзыв</p>
                <ul class="emoji-rate__list inline-flex gap-xs">
                    <li>
                        <input id="emoji-rate-option-no" wire:model.debounce.999999ms="rating_user" class="sr-only emoji-rate__native-input" type="radio" name="rating_user" value="1">

                        <label class="emoji-rate__custom-input emoji-rate__custom-input--no" for="emoji-rate-option-no">
                            <span class="sr-only">No</span>

                            <svg class="emoji-rate__icon" viewBox="0 0 40 40" aria-hidden="true">
                                <circle id="emoji-rate-no-bg" cx="20" cy="20" r="20" fill="var(--color-contrast-lower)" />
                                <g id="emoji-rate-no-eyes">
                                    <circle cx="11.5" cy="19.5" r="2.5" fill="currentColor" />
                                    <path d="M7,15a18.059,18.059,0,0,0,4,2,18.06,18.06,0,0,0,5,1" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    <circle cx="28.5" cy="19.5" r="2.5" fill="currentColor" />
                                    <path d="M33,15a18.059,18.059,0,0,1-4,2,18.06,18.06,0,0,1-5,1" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </g>
                                <path id="emoji-rate-no-mouth" d="M16,29a5,5,0,0,1,8,0" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                        </label>
                    </li>

                    <li>
                        <input id="emoji-rate-option-partially" wire:model.debounce.999999ms="rating_user" class="sr-only emoji-rate__native-input" type="radio" name="rating_user" value="2">

                        <label class="emoji-rate__custom-input emoji-rate__custom-input--partially" for="emoji-rate-option-partially">
                            <span class="sr-only">Partially</span>

                            <svg class="emoji-rate__icon" viewBox="0 0 40 40" aria-hidden="true">
                                <circle id="emoji-rate-partially-bg" cx="20" cy="20" r="20" fill="var(--color-contrast-lower)" />
                                <g id="emoji-rate-partially-eyes">
                                    <circle cx="11.5" cy="19.5" r="2.5" fill="currentColor" />
                                    <circle cx="28.5" cy="19.5" r="2.5" fill="currentColor" />
                                </g>
                                <line id="emoji-rate-partially-mouth" x1="15" y1="28" x2="25" y2="28" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                            </svg>
                        </label>

                        <svg class="emoji-rate__hand-icon" viewBox="0 0 40 40" aria-hidden="true">
                            <path id="emoji-rate-partially-hand" d="M17.279,28.031,4.323,29.1l-.33-3.986a2,2,0,0,0-3.986.33l.825,9.966a5.005,5.005,0,0,0,5.4,4.57l3.987-.33a3,3,0,0,0,2.742-3.237l-.33-3.986,4.983-.413a2,2,0,1,0-.33-3.986Z" fill="#e2ac4b"/>
                        </svg>
                    </li>

                    <li>
                        <input id="emoji-rate-option-yes" wire:model.debounce.999999ms="rating_user" class="sr-only emoji-rate__native-input" type="radio" name="rating_user" value="3">

                        <label class="emoji-rate__custom-input emoji-rate__custom-input--yes" for="emoji-rate-option-yes">
                            <span class="sr-only">Yes</span>

                            <svg class="emoji-rate__icon" viewBox="0 0 40 40" aria-hidden="true">
                                <circle id="emoji-rate-yes-bg" cx="20" cy="20" r="20" fill="var(--color-contrast-lower)" />
                                <g id="emoji-rate-yes-eyes">
                                    <path d="M9,19a3,3,0,0,1,6,0" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    <path d="M31,19a3,3,0,0,0-6,0" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </g>
                                <g id="emoji-rate-yes-mouth">
                                    <path d="M26,25H14a1,1,0,0,0-1,1,7,7,0,0,0,14,0A1,1,0,0,0,26,25Z" fill="currentColor" />
                                    <path id="emoji-rate-yes-tongue" d="M20,29a9.942,9.942,0,0,0-5.317,1.541,6.978,6.978,0,0,0,10.634,0A9.942,9.942,0,0,0,20,29Z" fill="var(--color-contrast-medium)" />
                                </g>
                            </svg>
                        </label>
                    </li>
                </ul>
            </div>

                <div class="overflow-hidden padding-y-md padding-x-md">

                <div class="grid gap-xxs">
                    <div class="col-6@md">
                        <input class="form-control width-100%" wire:model.debounce.999999ms="name" @error('name') form-control--error @enderror" type="text" name="name" id="name" placeholder="Имя" value="{{ old('name') }}">
                        @error('name')
                        <div role="alert" class="bg-error bg-opacity-20% padding-xxxs radius-md text-xs color-contrast-higher margin-top-xxs"><p><strong>ошибка:</strong> {{ $message }}</p></div>
                        @enderror
                    </div>

                    <div class="col-6@md">
                        <input class="form-control width-100%" wire:model.debounce.999999ms="email" @error('email') form-control--error @enderror" type="email" name="email" id="email" placeholder="email@myemail.com">
                        @error('email')
                        <div role="alert" class="bg-error bg-opacity-20% padding-xxxs radius-md text-xs color-contrast-higher margin-top-xxs"><p><strong>ошибка:</strong> {{ $message }}</p></div>
                        @enderror
                    </div>
                </div>

                <div class="col margin-y-sm">
                    <label class="control-label form-label margin-bottom-xxs" for="period_use">Период владения браслетом <span class="text-bold">{{ $model->name }}</span>:</label>
                    <div class="select">
                        <select class="select__input form-control" name="period_use" wire:model.debounce.999999ms="period_use" id="period_use">
                            <option value="">Выбрать период</option>
                            <option value="Несколько дней">Несколько дней</option>
                            <option value="Более 2-х недель">Более 2-х недель</option>
                            <option value="Более месяца">Более месяца</option>
                            <option value="Более полугода">Более полугода</option>
                        </select>

                        <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16">
                            <g stroke-width="1" stroke="currentColor">
                                <polyline fill="none" stroke="currentColor" stroke-linecap="round"
                                          stroke-linejoin="round" stroke-miterlimit="10"
                                          points="15.5,4.5 8,12 0.5,4.5 "></polyline>
                            </g>
                        </svg>
                    </div>
                </div>

                <div class="margin-y-md">
                    <div x-data="{textEditor:@entangle('review_text').defer}"
                        x-init="()=>{var element = document.querySelector('trix-editor');
                                   element.editor.insertHTML(textEditor);}"
                        wire:ignore>

                   <input x-ref="editor"
                          id="editor-x"
                          type="hidden"
                          name="content">

                   <trix-editor class="trix-editor border-gray-300 trix-content" input="editor-x"
                                x-on:trix-change="textEditor=$refs.editor.value;"
                   ></trix-editor>
                   </div>

                </div>
                @error('review_text')
                <div role="alert" class="bg-error bg-opacity-20% padding-xxxs radius-md text-xs color-contrast-higher margin-top-xxs"><p><strong>ошибка:</strong> {{ $message }}</p></div>
                @enderror

                <div class="margin-top-xs text-right">
                    <button type="submit" class="btn btn--primary">Отправить</button>
                </div>
            </div>
        </div>
        </form>
</div>




