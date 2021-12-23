@props(['id'=>Str::random(5),'editorheight'=>null])
<div x-data="{textEditor:@entangle($attributes->wire('model')).defer}"
     x-init="()=>{setEditor{{$id}}Value(textEditor)}"
     @reseteditor{{$id}}.window="setEditorValue('');"
     wire:ignore>
    <input x-ref="editor{{$id}}"
           id="editor-x{{$id}}"
           type="hidden"
           name="content">
    <trix-editor id="editor{{$id}}"  input="editor-x{{$id}}"
                 x-on:trix-change="textEditor=$refs.editor{{$id}}.value;"
    ></trix-editor>
</div>

@once
    @section('footerScripts')
        @parent
        <script type="text/javascript" src="{{ asset('js/admin/trix.js') }}"></script>
    @endsection
@endonce

@section('scripts')
    @parent
    <script>
        function setEditor{{$id}}Value(value) {
            let element{{$id}}= document.getElementById("editor{{$id}}");
            let input = document.getElementById("editor-x{{$id}}");
            if(value=='') {
                input.value = "";
                element.innerHTML = "";
            }
            else {
                element{{$id}}.editor.insertHTML(value);
            }
        }
    </script>
@endsection

@section('style')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin/trix.css') }}">
    <style>
        .trix-button-group--file-tools{
            display: none!important;
        }
        .trix-button--icon-decrease-nesting-level{
            display: none;
        }
        .trix-button--icon-increase-nesting-level{
            display: none;
        }
        #editor{{$id}}
     {
            height: {{$editorheight ?? '10rem'}};
        }
    </style>
@endsection
