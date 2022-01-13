<div>
    <section>
        <div class="text-component padding-y-sm">
            {{ $slot }}
        </div>
        <div class="border radius-md padding-sm bg-gradient-3">
            <label class="form-label margin-bottom-xxs sr-only" for="code">Основной
                контент</label>
            <textarea class="form-control width-100% text-sm code"
                      spellcheck="false" name="{{ $name }}" id="{{ $id }}">{{ $content }}</textarea>
        </div>
    </section>
        @push('js')
        @once
        <script src="{{ asset("js/admin/codemirror.min.js") }}"></script>
        <script src="{{ asset("js/admin/xml-fold.js") }}"></script>
        <script src="{{ asset("js/admin/closetag.js") }}"></script>
        <script src="{{ asset("js/admin/matchtags.js") }}"></script>
        <script src="{{ asset("js/admin/trailingspace.js") }}"></script>
        <script src="{{ asset("js/admin/xml.js") }}"></script>
        <script src="{{ asset("js/admin/fullscreen.js") }}"></script>
            <script type="text/javascript">
                function qsa(sel) {
                    return Array.apply(null, document.querySelectorAll(sel));
                }
                qsa(".code").forEach(function (editorEl) {
                    CodeMirror.fromTextArea(editorEl, {
                        lineNumbers: true,
                        tabSize: 2,
                        mode: "text/html",
                        autoCloseTags: true,
                        lineWrapping: true,
                        matchTags: {bothTags: true},
                        showTrailingSpace: true,
                        extraKeys: {
                            "Ctrl-J": "toMatchingTag",
                            "F11": function (cm) {
                                cm.setOption("fullScreen", !cm.getOption("fullScreen"));
                            },
                            "Esc": function (cm) {
                                if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
                            }
                        }
                    });
                });
            </script>
            @endonce
        @endpush
</div>
