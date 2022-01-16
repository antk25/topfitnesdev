@extends('layouts.base')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/simple-lightbox.min.css') }}">
@endpush

@section('title')
    {{ $post->title }}
@endsection

@section('description')
    {{ $post->description }}
@endsection

@section('content')
    <div class="container max-width-md padding-top-md">
        {{ Breadcrumbs::render('post', $post) }}
    </div>


    <article class="padding-y-md">
        <header class="container max-width-md margin-bottom-lg">
            <div class="text-component line-height-lg text-space-y-md margin-bottom-md">
                <h1>{{ $post->subtitle }}</h1>
                <p class="color-contrast-medium text-sm">{{ $post->created_at->diffForHumans() }}</p>
            </div>
        </header>
        <section class="main">
            <div class="container max-width-adaptive-md">
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

                    {!! $post->content !!}

                    @if($post->sources)
                        <div class="footnotes margin-top-xl">
                            <p class="text-md">Источники</p>
                            {!! $post->sources !!}
                        </div>
                    @endif

                </div>
            </div>
        </section>


    </article>

    <div class="container max-width-md padding-top-md">
        <div class="author ">
            <a href="#0" class="author__img-wrapper">
                <img src="{{ $post->user->getFirstMediaUrl('avatars') }}" alt="Author picture">
            </a>
            <div class="author__content text-component v-space-xxs">
                <h4><a href="#0" rel="author">{{ $post->user->name }}</a></h4>
                <p class="color-contrast-medium">{{ $post->user->about }}</p>
                <p class="text-sm"><a href="#0">@oliviagribben</a></p>
            </div>
        </div>
    </div>

    <div class="container max-width-md padding-top-md">
        <div class="bg padding-md padding-x-lg@md margin-y-sm@md">

            @livewire('comment.comments', ['model' => $post, 'user' => $user])

            {{-- <livewire:comments :comments="$rating->comments", :user="$user", :post_id='$rating->id'> --}}
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
