@extends('layouts.base')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/simple-lightbox.min.css') }}">
@endpush

@section('title')
    {{ $staticPage->title }}
@endsection

@section('description')
    {{ $staticPage->description }}
@endsection

@section('content')
    <div class="container max-width-sm padding-top-md">
        {{ Breadcrumbs::render('static_page', $staticPage) }}
    </div>

    <article class="padding-y-md">
        <header class="container max-width-sm margin-bottom-lg">
            <div class="text-component line-height-lg text-space-y-md margin-bottom-md">
                <h1>{{ $staticPage->subtitle }}</h1>
                <p class="color-contrast-medium text-sm">
                    @if($staticPage->updated_at)
                    {{ $staticPage->updated_at->diffForHumans() }}
                        @else
                    {{ $staticPage->created_at->diffForHumans() }}
                    @endif
                </p>
            </div>
        </header>
        <section class="main">
            <div class="container max-width-adaptive-sm">
                <div class="text-component line-height-lg text-space-y-md text-component--has-footnotes">

                    {!! $staticPage->content !!}

                </div>
            </div>
        </section>


    </article>

@endsection

@push('js')
    <script src="{{ asset("js/simple-lightbox.min.js") }}"></script>
@endpush
