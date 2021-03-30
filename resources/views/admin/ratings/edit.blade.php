@extends('admin.layouts.base')

@section('content')

<div class="container max-width-md">
  
    
  @livewire('admin.bracelets-in-rating', ['rating' => $rating, 'edit' => 1])
    
</div>

@endsection

@section('scripts')
@parent
{{-- <script src="{{ asset("js/admin/alpine.min.js") }}"></script> --}}
    <script src="{{ asset("js/admin/vs/loader.js") }}"></script>
		<script>
			require.config({ paths: { vs: '{{ asset("js/admin/vs") }}' } });

			require(['vs/editor/editor.main'], function () {
				var editor = monaco.editor.create(document.getElementById('container'), {
					value: ['{!! str_replace(array("\r\n", "\r", "\n"), "", $rating->text) !!}'].join('\n'),
					language: 'html'
				});
			});
		</script>
@endsection