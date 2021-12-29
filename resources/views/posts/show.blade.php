@extends('layouts.base')

@section('title')
{{ $post->title }}
@endsection

@section('description')
{{ $post->description }}
@endsection

@section('content')
<div class="position-relative z-index-1 bg-contrast-lower padding-y-lg">
  <div class="container max-width-adaptive-md">

    <article class="t-article-v4 bg padding-md padding-x-lg@md padding-y-xl@md">

      <div class="text-component text-center line-height-lg v-space-xxl max-width-xs margin-x-auto">
        <p class="text-xs text-uppercase letter-spacing-lg color-contrast-medium">{{ $post->created_at->diffForHumans() }}</p>
        <h1>{{ $post->subtitle }}</h1>
      </div>

      <div class="t-article-v4__divider margin-y-lg" aria-hidden="true"><span></span></div>

      <div class="text-component line-height-lg v-space-md">

        {!! $post->content !!}

      </div>


<div class="author ">
  <a href="#0" class="author__img-wrapper">
    <img src="../../../app/assets/img/author-img-1.jpg" alt="Author picture">
  </a>

  <div class="author__content text-component v-space-xxs">
    <h4><a href="#0" rel="author">{{ $post->user->name }}</a></h4>
    <p class="color-contrast-medium">{{ $post->user->about }}</p>
    <p class="text-sm"><a href="#0">@oliviagribben</a></p>
  </div>
</div>


    </article>

    <div class="bg padding-md padding-x-lg@md margin-y-sm@md">
      <div class="text-component">
      <h2>Наши рекомендации</h2>
      </div>
     <ol class="margin-bottom-md margin-top-md" aria-label="Наши рекомендации">

</ol>

    </div>


    <div class="bg padding-md padding-x-lg@md margin-y-sm@md">

    @livewire('comment.comments', ['model' => $post, 'user' => $user])

      {{-- <livewire:comments :comments="$rating->comments", :user="$user", :post_id='$rating->id'> --}}
      </div>
  </div>
</div>

@endsection

@section('footerScripts')
@parent

@endsection
