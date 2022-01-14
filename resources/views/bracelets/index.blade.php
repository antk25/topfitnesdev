@extends('layouts.base')

@section('content')
    <div class="container max-width-md padding-top-md">
        {{ Breadcrumbs::render('katalog') }}
    </div>

    @livewire('product.bracelets')

@endsection
