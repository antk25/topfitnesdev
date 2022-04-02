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
<progress aria-hidden="true" class="reset reading-progressbar js-reading-progressbar" max="100" value="0">
    <div class="reading-progressbar__fallback js-reading-progressbar__fallback"></div>
</progress>
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
            <div class="container max-width-adaptive-sm js-toc-content">
                <div class="text-component line-height-lg text-space-y-md">

                    <details class="details js-details margin-y-sm">
                        <summary class="details__summary js-details__summary" role="button">
                            <span class="flex items-center color-primary font-bold">
                                <svg class="icon icon--xxs margin-right-xxxs" aria-hidden="true" viewBox="0 0 12 12"><path
                                        d="M2.783.088A.5.5,0,0,0,2,.5v11a.5.5,0,0,0,.268.442A.49.49,0,0,0,2.5,12a.5.5,0,0,0,.283-.088l8-5.5a.5.5,0,0,0,0-.824Z"></path></svg>
                                <span>Содержание статьи</span>
                            </span>
                        </summary>
                        <div class="details__content text-component margin-top-xs js-details__content">
                            <div class="js-tocs">
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

    <x-cards.author :author="$comparison->user" class="container max-width-sm">
    </x-cards.author>

    <div class="container max-width-sm padding-top-md">
        <div class="bg">

            @livewire('comment.comments', ['model' => $comparison, 'user' => $user, 'comments_count' => $comparison->comments_count])

        </div>
    </div>

@endsection

@push('js')
    <script src="{{ asset("js/alpine.min.js") }}"></script>
    <script src="{{ asset("js/lazyload.min.js") }}"></script>
    <script src="{{ asset("js/tocbot.min.js") }}"></script>
    <script src="{{ asset("js/simple-lightbox.min.js") }}"></script>
    <script>
        new SimpleLightbox('.box a', { /* options */});

        var lazyLoadInstance = new LazyLoad({
            elements_selector: ".lazy"
        });

        function makeIds () { // eslint-disable-line
        var content = document.querySelector('.js-toc-content')
        var headings = content.querySelectorAll('h1, h2, h3, h4, h5, h6, h7')
        var headingMap = {}

        Array.prototype.forEach.call(headings, function (heading) {
            var id = heading.id
            ? heading.id
            : heading.textContent.trim().toLowerCase()
                .split(' ').join('-').replace(/[!@#$%^&*():]/ig, '').replace(/\//ig, '-')
            headingMap[id] = !isNaN(headingMap[id]) ? ++headingMap[id] : 0
            if (headingMap[id]) {
            heading.id = id + '-' + headingMap[id]
            } else {
            heading.id = id
            }
        })
        }
        makeIds()

        tocbot.init({
            tocSelector: '.js-tocs',
            contentSelector: '.js-toc-content',
            headingSelector: 'h2, h3',
            hasInnerContainers: true,
            linkClass: 'text-bg-fx',
            extraLinkClasses: 'text-bg-fx--scale-y',
            activeLinkClass: ' ',
            listClass: 'list',
            extraListClasses: 'list--ul',
            listItemClass: 'toc-item',
            activeListItemClass: '',
            collapseDepth: 6,
            scrollSmoothOffset: -60,
        });
    </script>
@endpush
