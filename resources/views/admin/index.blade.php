@extends('admin.layouts.base')

@section('content')
<div class="margin-bottom-md">
  <div class="flex flex-column gap-sm flex-row@sm justify-between@sm items-baseline@sm">
    <h1 class="text-lg">Dashboard</h1>
  </div>
</div>

<div class="grid gap-sm">

  <!-- alert -->
  <div class="alert-card bg radius-md padding-md shadow-xs col-12 js-alert-card">
    <div class="text-component line-height-lg">
      <h1 class="text-lg flex flex-wrap items-center">
        <svg class="block icon icon--md margin-right-xxs color-accent" viewBox="0 0 32 32" aria-hidden="true"><circle opacity="0.2" cx="16" cy="16" r="16"/><path opacity="0.2" d="M25.7,3.3A15.98,15.98,0,0,1,3.3,25.7,15.986,15.986,0,1,0,25.7,3.3Z"/><circle opacity="0.2" cx="14" cy="9" r="3"/><circle opacity="0.2" cx="7.5" cy="16.5" r="1.5"/><circle opacity="0.2" cx="19.5" cy="18.5" r="2.5"/></svg>
        <span>Добро пожаловать в админку TopFitnesBraslet</span>
      </h1>

      <p class="color-contrast-medium">Вы можете перейти на сам сайт по ссылке <a href="/">перейти на сайт &rarr;</a>.</p>
    </div>

    <button class="reset alert-card__close-btn js-tab-focus js-alert-card__close-btn">
      <svg class="icon icon--xs" viewBox="0 0 16 16"><title>Hide alert</title><g fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2"><line x1="1" y1="1" x2="15" y2="15"/><line x1="15" y1="1" x2="1" y2="15"/></g></svg>
    </button>
  </div>
</div>
@endsection