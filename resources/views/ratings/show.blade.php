@extends('layouts.base')

@section('content')
<div class="container max-width-adaptive-lg padding-top-md">
  <nav class="breadcrumbs text-sm" aria-label="Breadcrumbs">
    <ol class="flex flex-wrap gap-xxs">
      <li class="breadcrumbs__item">
        <a href="/" class="color-inherit"><svg class="icon margin-right-xxxs" viewBox="0 0 16 16" aria-hidden="true"><g fill="none" stroke-width="1" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><polyline points=" 15.5,7.5 8,0.5 0.5,7.5 "></polyline><polyline points="2.5,8.5 2.5,15.5 6.5,15.5 6.5,11.5 9.5,11.5 9.5,15.5 13.5,15.5 13.5,8.5 "></polyline></g></svg></a>
        <svg class="icon margin-left-xxxs color-contrast-medium" aria-hidden="true" viewBox="0 0 16 16"><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="6.5,3.5 11,8 6.5,12.5 "></polyline></g></svg>
      </li>
  
      <li class="breadcrumbs__item" aria-current="page">{{ $rating->name }}</li>
    </ol>
  </nav>
<div class="margin-y-sm text-component">
  <h1>{{ $rating->name }}</h1>
</div>
<div class="text-component">

{!! $rating->text !!}

</div>
@foreach ($rating->bracelets as $bracelet)
 {{ $bracelet->name }}<br> 
 {{ $bracelet->pivot->text_rating }}<br>
@endforeach
 
@livewire('comments', ['rating' => $rating->id, 'user' => $user, 'post_id' => $rating->id, 'commentable_type' => get_class($rating)])

{{-- <livewire:comments :comments="$rating->comments", :user="$user", :post_id='$rating->id'> --}}


</div>

@endsection

@section('footerScripts')
@parent
@endsection


