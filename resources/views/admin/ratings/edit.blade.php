@extends('admin.layouts.base')

@section('content')

<div class="container max-width-md">
  
    
  @livewire('admin.bracelets-in-rating', ['rating' => $rating, 'edit' => 1])
    
</div>

@endsection

@section('scripts')
@parent
{{-- <script src="{{ asset("js/admin/alpine.min.js") }}"></script> --}}

@endsection