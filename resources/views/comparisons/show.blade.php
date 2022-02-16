@extends('layouts.base')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/simple-lightbox.min.css') }}">
@endpush

@section('title')
    {{ $comparison->title }}
@endsection

@section('description')
    {{ $comparison->description }}
@endsection

@section('content')
    <div class="container max-width-sm padding-top-md">
        {{ Breadcrumbs::render('comparison', $comparison) }}
    </div>


    <article class="padding-y-md">
        <header class="container max-width-sm margin-bottom-lg">
            <div class="text-component line-height-lg text-space-y-md margin-bottom-md">
                <h1>{{ $comparison->subtitle }}</h1>
                <p class="color-contrast-medium text-sm">
                    @if($comparison->updated_at)
                    {{ $comparison->updated_at->diffForHumans() }}
                        @else
                    {{ $comparison->created_at->diffForHumans() }}
                    @endif
                </p>
            </div>
        </header>
        <section class="main">
            <div class="container max-width-adaptive-sm">
                <div class="text-component line-height-lg text-space-y-md">

                    <div class="text-component__block">
                        <x-dynamic-component :component="$comparison->type_table" :bracelets="$bracelets" :specs="$comparison->list_specs" />
                    </div>

                    <details class="details js-details margin-y-sm">
                        <summary class="details__summary js-details__summary" role="button">
                        <span class="flex items-center color-primary font-bold">
                        <svg class="icon icon--xxs margin-right-xxxs" aria-hidden="true" viewBox="0 0 12 12"><path
                                d="M2.783.088A.5.5,0,0,0,2,.5v11a.5.5,0,0,0,.268.442A.49.49,0,0,0,2.5,12a.5.5,0,0,0,.283-.088l8-5.5a.5.5,0,0,0,0-.824Z"></path></svg>
                      <span>Содержание статьи</span>

                    </span>
                        </summary>

                        <div class="details__content text-component margin-top-xs js-details__content">
                            <div class="toc non-jquery">

                            </div>

                        </div>
                    </details>

                    {!! $comparison->content !!}

                    @if($comparison->sources)
                        <div class="footnotes margin-top-xl">
                            <p class="text-md">Источники</p>
                            {!! $comparison->sources !!}
                        </div>
                    @endif

                </div>
            </div>
        </section>


    </article>

    <x-cards.author :author="$comparison->user">
    </x-cards.author>

    <div class="container max-width-sm padding-top-md">
        <div class="bg">

            @livewire('comment.comments', ['model' => $comparison, 'user' => $user])

            {{-- <livewire:comments :comments="$rating->comments", :user="$user", :post_id='$rating->id'> --}}
        </div>
    </div>

@endsection

@push('js')
    <script src="{{ asset("js/alpine.min.js") }}"></script>
    <script src="{{ asset("js/lazyload.min.js") }}"></script>
    <script src="{{ asset("js/toc.min.js") }}"></script>
    <script src="{{ asset("js/simple-lightbox.min.js") }}"></script>
    <script>
        var options = {
            selector: 'h2, h3, h4',
            scope: 'section.main'
        };
        var container = document.querySelector('.toc.non-jquery');

        var toc = initTOC(options);

        container.appendChild(toc);

        new SimpleLightbox('.box a', { /* options */});

        var lazyLoadInstance = new LazyLoad({
            elements_selector: ".lazy"
        });
    </script>
@endpush
