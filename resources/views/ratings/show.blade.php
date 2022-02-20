@extends('layouts.base')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/simple-lightbox.min.css') }}">
@endpush

@section('title')
    {{ $rating->title }}
@endsection

@section('description')
    {{ $rating->description }}
@endsection

@section('content')
<progress aria-hidden="true" class="reset reading-progressbar js-reading-progressbar" max="100" value="0">
    <div class="reading-progressbar__fallback js-reading-progressbar__fallback"></div>
</progress>
    <div class="container max-width-md padding-top-md">
        {{ Breadcrumbs::render('rating', $rating) }}
    </div>

    <article class="padding-y-md">
        <header class="container max-width-md margin-bottom-lg">
            <div class="text-component line-height-lg text-space-y-md margin-bottom-md">
                <h1>{{ $rating->subtitle }}</h1>
                <p class="color-contrast-medium text-sm">
                    @if($rating->updated_at)
                    {{ $rating->updated_at->diffForHumans() }}
                        @else
                    {{ $rating->created_at->diffForHumans() }}
                    @endif

                    &nbsp;
                    @if ($rating->comments_count)
                    <a class="text-bg-fx text-bg-fx--underline text-bg-fx--text-shadow" href="#comments">
                    <svg class="icon" viewBox="0 0 12 12">
                        <g>
                          <path d="M6,0C2.691,0,0,2.362,0,5.267s2.691,5.266,6,5.266a6.8,6.8,0,0,0,1.036-.079l2.725,1.485A.505.505,0,0,0,10,12a.5.5,0,0,0,.5-.5V8.711A4.893,4.893,0,0,0,12,5.267C12,2.362,9.309,0,6,0Z"></path>
                        </g>
                      </svg>
                        {{ $rating->comments_count }} {{ trans_choice('комментарий|комментария|комментариев', $rating->comments_count) }}
                    </a>
                    @else
                    <a class="text-bg-fx text-bg-fx--underline text-bg-fx--text-shadow" href="#createcomment">
                    <svg class="icon" viewBox="0 0 12 12">
                        <g>
                          <path d="M6,0C2.691,0,0,2.362,0,5.267s2.691,5.266,6,5.266a6.8,6.8,0,0,0,1.036-.079l2.725,1.485A.505.505,0,0,0,10,12a.5.5,0,0,0,.5-.5V8.711A4.893,4.893,0,0,0,12,5.267C12,2.362,9.309,0,6,0Z"></path>
                        </g>
                      </svg>
                      Задать вопрос
                    </a>
                    @endif
                </p>
            </div>
        </header>
<section class="main">
        <div class="container max-width-adaptive-md js-toc-content">
            <div class="text-component line-height-lg text-space-y-md">
                <div class="text-component__block">
                    <x-dynamic-component :component="$rating->type_table" :bracelets="$rating->bracelets" :specs="$rating->list_specs" />
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
                            <div class="js-tocs">
                            </div>
                        </div>
                    </details>

                {!! $rating->intro !!}

                <x-cards.bracelet-article :bracelets="$rating->bracelets" typeGrade="{{ $rating->type_grade }}">

                </x-cards.bracelet-article>

                {!! $rating->conclusion !!}

            </div>
        </div>
</section>
    </article>

    <x-cards.author :author="$rating->user" class="container max-width-md">
    </x-cards.author>

<div class="container max-width-md">
    @if (count($topbracelets))
    <div class="bg padding-x-lg@md margin-y-sm@md">
        <div class="text-component">
            <p class="text-lg">Наши рекомендации</p>
        </div>
        <ol class="margin-bottom-md margin-top-md" aria-label="Наши рекомендации">
            @foreach ($topbracelets as $topbracelet)
                <li class="cart__product flex padding-y-sm">
                    <div class="cart__product-img margin-right-sm">
                        <a href="#0" class="radius-md shadow-md">
                            <img alt="Изображение {{ $topbracelet->name }}"
                                 src="{{ $topbracelet->getFirstMediaUrl('bracelets', 'thumb') }}">
                        </a>
                    </div>

                    <div class="cart__product-info">
                        <div class="text-component v-space-sm">
                            <h2 class="text-md"><a class="link-fx-5"
                                                   href="/katalog/{{ $topbracelet->slug }}"
                                                   class="color-inherit">{{ $topbracelet->name }}</a></h2>
                            <p class="text-sm color-contrast-medium"><span class="text-bold">Оценка:</span>
                                <span class="inline-block text-sm bg-success bg-opacity-20% text-bold radius-full padding-y-xxxs padding-x-xs ws-nowrap">
                                    {{ $topbracelet->grade_bracelet }}
                                </span>
                            </p>
                            <p class="text-sm color-contrast-medium">
                                <span class="text-bold">Мониторинг:</span>
                                @foreach ($topbracelet->monitoring as $monitoring)
                                    @if ($loop->last)
                                        {{ $monitoring }}
                                    @else
                                        {{ $monitoring }},
                                    @endif
                                @endforeach
                            </p>
                        </div>

                        <div class="cart__product-tot">
                            <div>
                                <p class="text-md"><span class="text-sm">Средняя цена:</span>
                                    {{ $topbracelet->avg_price }} Р.</p>

                                <a href="/katalog/{{ $topbracelet->slug }}"
                                   class="cart__remove-btn margin-top-xxs">Сравнить цены</a>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ol>
    </div>
        @endif

    <div class="container max-width-sm padding-top-md">
        <div class="bg">

            @livewire('comment.comments', ['model' => $rating, 'user' => $user, 'comments_count' => $rating->comments_count])

        </div>
    </div>
</div>
    @if (Auth::check())
        @can('view-admin-panel')
            <div class="notice bottom-md js-notice">
                <div class="container">
                    <div class="notice__banner bg-light padding-xs radius-md inner-glow shadow-md inline-flex items-center text-sm">
                        <p class="flex-grow margin-right-sm margin-left-xxs">Редактировать страницу:</p>

                        <a type="button" href="{{ route('ratings.edit', ['rating' => $rating->id]) }}" class="btn btn--primary padding-x-xs padding-y-xxs js-notice__hide-control">Перейти</a>
                    </div>
                </div>
            </div>
        @endcan
    @endif

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
