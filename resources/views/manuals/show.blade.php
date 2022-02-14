@extends('layouts.base')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/simple-lightbox.min.css') }}">
@endpush

@section('title')
    {{ $manual->title }}
@endsection

@section('description')
    {{ $manual->description }}
@endsection

@section('content')
    <div class="container max-width-sm padding-top-md">
        {{ Breadcrumbs::render('manual', $manual) }}
    </div>


    <article class="padding-y-md">
        <header class="container max-width-sm margin-bottom-lg">
            <div class="text-component line-height-lg text-space-y-md margin-bottom-md">
                <h1>{{ $manual->subtitle }}</h1>
                <p class="color-contrast-medium text-sm">
                    @if($manual->updated_at)
                    {{ $manual->updated_at->diffForHumans() }}
                        @else
                    {{ $manual->created_at->diffForHumans() }}
                    @endif
                </p>
            </div>
        </header>
        <section class="main">
            <div class="container max-width-adaptive-sm">
                <div class="text-component line-height-lg text-space-y-md text-component--has-footnotes">

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

                    {!! $manual->content !!}

                    @if($manual->sources)
                        <div class="footnotes margin-top-xl">
                            <p class="text-md">Источники</p>
                            {!! $manual->sources !!}
                        </div>
                    @endif

                    <x-cards.bracelet-article :bracelets="$manual->bracelets" typeGrade="average_grade">
                    </x-cards.bracelet-article>

                </div>
            </div>
        </section>

    </article>

    <x-cards.author :author="$manual->user" class="container max-width-sm">
    </x-cards.author>



    <div class="container max-width-sm padding-top-md">
        <div class="bg">

            @livewire('comment.comments', ['model' => $manual, 'user' => $user])

        </div>
    </div>

@endsection

@push('js')
    <script src="{{ asset("js/alpine.min.js") }}"></script>
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
    </script>
@endpush
