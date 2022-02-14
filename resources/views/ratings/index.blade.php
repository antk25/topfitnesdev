@extends('layouts.base')

@section('title')
   Рейтинги фитнес-браслетов
@endsection

@section('description')
    Все рейтинги фитнес-браслетов
@endsection

@section('content')

    <div class="container max-width-md padding-top-md">
        {{ Breadcrumbs::render('ratings') }}
    </div>

    <section class="articles-v3 padding-y-md">
        <div class="container max-width-adaptive-md">
            <ul class="grid gap-lg">
                @foreach($ratings as $item)
                    <li>
                        <div class="grid gap-md items-start">
                            <a href="{{ route('pub.ratings.show', ['rating' => $item]) }}" class="articles-v3__img col-6@md col-7@xl">
                                <figure class="aspect-ratio-16:9">
                                    <img src="{{ $item->getFirstMediaUrl('covers') }}" alt="{{ $item->name }}">
                                </figure>
                            </a>

                            <div class="col-6@md col-5@xl">
                                <div class="text-component">
                                    <h4 class="articles-v3__headline"><a href="{{ route('pub.ratings.show', ['rating' => $item]) }}">{{ $item->name }}</a></h4>
                                    <p>{!! Str::words($item->description, 20) !!}</p>
                                </div>

                                <div class="articles-v3__author">
                                    <a href="#0" class="articles-v3__author-img">
                                        @if ($author->getFirstMediaUrl('avatars'))
                                            <img src="{{ $item->user->getFirstMediaUrl('avatars') }}" alt="Author picture">
                                        @else
                                            <img src="{{ asset('/img/theme/comments-placeholder.svg') }}" alt="Author picture">
                                        @endif
                                    </a>

                                    <div class="text-component text-sm line-height-xs text-space-y-xxs">
                                        <p><a href="#0" class="articles-v3__author-name" rel="author">{{ $item->user->name }}</a></p>
                                        <p class="color-contrast-medium"><time>
                                                @if($item->updated_at)
                                                    {{ $item->updated_at->diffForHumans() }}
                                                @else
                                                    {{ $item->created_at->diffForHumans() }}
                                                @endif</time></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
@endsection
