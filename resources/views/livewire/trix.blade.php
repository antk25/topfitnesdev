<div wire:ignore>
    <div
        x-data="{ trix: '{{ $review_text }}' }"
        {{--                        @trix-blur="$wire.call('updateContent', $refs.trix.value)"--}}
    >
        <div wire:ignore>
            <trix-editor
                x-ref="trix"
                x-model.debounce="trix"
            ></trix-editor>
        </div>

    </div>

    <textarea wire:model="value" id="{{ $trixId }}" class="hide" name="content">{{ $value }}</textarea>
    <trix-toolbar id="toolbar1">
        <div class="trix-button-row">
        <span class="trix-button-group trix-button-group--text-tools" data-trix-button-group="text-tools">
            <button type="button" class="trix-button trix-button--icon trix-button--icon-bold"
                    data-trix-attribute="bold" data-trix-key="b" title="Bold" tabindex="-1">B</button>
            <button type="button" class="trix-button trix-button--icon trix-button--icon-quote"
                    data-trix-attribute="quote" data-trix-key="q" title="Quote" tabindex="-1">Цитата</button>
            <button type="button" class="trix-button trix-button--icon trix-button--icon-bullet-list"
                    data-trix-attribute="bullet" title="Bullets" tabindex="-1" data-trix-active="">Список</button>
            <button type="button" class="trix-button trix-button--icon trix-button--icon-number-list"
                    data-trix-attribute="number" title="Numbers" tabindex="-1">Нумерованный список</button>
            <button type="button" class="trix-button trix-button--icon trix-button--icon-link"
                    data-trix-attribute="href" data-trix-action="link" data-trix-key="k" title="Link"
                    tabindex="-1">Link</button>
        </span>

            <span class="trix-button-group trix-button-group--history-tools" data-trix-button-group="history-tools">
                    <button type="button" class="trix-button trix-button--icon trix-button--icon-redo"
                            data-trix-action="redo" data-trix-key="shift+z" title="Redo" tabindex="-1"
                            disabled="">Redo</button>
                    <button type="button" class="trix-button trix-button--icon trix-button--icon-undo"
                            data-trix-action="undo" data-trix-key="z" title="Undo" tabindex="-1"
                            disabled="">Undo</button>
        </span>
        </div>

        <div class="trix-dialogs" data-trix-dialogs="">
            <div class="trix-dialog trix-dialog--link" data-trix-dialog="href" data-trix-dialog-attribute="href">
                <div class="trix-dialog__link-fields">
                    <input type="url" name="href" class="trix-input trix-input--dialog" placeholder="Enter a URL…" aria-label="URL" required="" data-trix-input="" disabled="disabled">
                    <div class="trix-button-group">
                        <input type="button" class="trix-button trix-button--dialog" value="Link" data-trix-method="setAttribute">
                        <input type="button" class="trix-button trix-button--dialog" value="Unlink" data-trix-method="removeAttribute">
                    </div>
                </div>
            </div>
        </div>
    </trix-toolbar>

    <trix-editor toolbar="toolbar1" input="{{ $trixId }}"></trix-editor>

    <script src="{{ asset('js/admin/trix.js') }}"></script>

    <script>
        var trixEditor = document.getElementById("{{ $trixId }}");

        addEventListener("trix-blur", function(event) {

        @this.set('value', trixEditor.value)
        //     @this.value = trixEditor.value
        })

    </script>

</div>
