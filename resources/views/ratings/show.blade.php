@extends('layouts.base')

@section('title')
    {{ $rating->title }}
@endsection

@section('description')
    {{ $rating->description }}
@endsection

@section('content')
    <div class="container max-width-sm padding-top-md">
        {{ Breadcrumbs::render('rating', $rating) }}
    </div>

    <article class="padding-y-md">
        <header class="container max-width-sm margin-bottom-lg">
            <div class="text-component line-height-lg text-space-y-md margin-bottom-md">
                <h1>{{ $rating->subtitle }}</h1>
                <p class="color-contrast-medium text-sm">{{ $rating->created_at->diffForHumans() }}</p>
            </div>
        </header>
<section class="main">
        <div class="container max-width-adaptive-sm">
            <div class="text-component line-height-lg text-space-y-md">
                <div class="text-component__block--outset">
                    <x-dynamic-component :component="$rating->type_table" :bracelets="$bracelets" :specs="$rating->list_specs" />
                </div>
                <button class="btn btn--primary margin-y-sm" aria-controls="collapse-content">Table of Contents</button>
                <div id="collapse-content" class="is-hidden js-collapse" data-collapse-animate="on">
                    <div class="toc non-jquery">

                    </div>
                </div>

                {!! $rating->text !!}

                <x-cards.bracelet-article :bracelets="$rating->bracelets" />

            </div>
        </div>
</section>
    </article>

<div class="container max-width-md">

    <div class="bg padding-md padding-x-lg@md margin-y-sm@md">
        <div class="text-component">
            <h2>Наши рекомендации</h2>
        </div>
        <ol class="margin-bottom-md margin-top-md" aria-label="Наши рекомендации">
            @foreach ($topbracelets as $topbracelet)
                <li class="cart__product flex padding-y-sm">
                    <div class="cart__product-img margin-right-sm">
                        <a href="#0" class="radius-md shadow-md">
                            <img alt="Изображение {{ $topbracelet->name }}"
                                 src="{{ $topbracelet->getFirstMediaUrl('bracelet', 'thumb') }}">
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

    <div class="bg padding-md padding-x-lg@md margin-y-sm@md">
        @livewire('comment.comments', ['model' => $rating, 'user' => $user])
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

@section('footerScripts')
    @parent
    <script src="{{ asset("js/toc.min.js") }}"></script>
    <script>
        var options = {
            selector: 'h2, h3, h4',
            scope: 'section.main'
        };
        var container = document.querySelector('.toc.non-jquery');

        var toc = initTOC(options);

        container.appendChild(toc);
    </script>
@endsection
