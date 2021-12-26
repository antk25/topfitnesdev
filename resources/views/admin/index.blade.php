@extends('admin.layouts.base')

@section('content')

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

<div class="grid gap-sm margin-top-md">
  <a class="link-card flex flex-column bg radius-md col-6@sm col-4@lg" href="{{ route('components') }}" aria-label="Link label">
    <div class="padding-md">
      <div class="flex flex-wrap gap-xs items-center">
        <figure>
          <svg class="block color-accent" width="72" height="72" viewBox="0 0 72 72">
            <circle fill="currentColor" opacity="0.15" cx="36" cy="36" r="36"/>
            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
              <polyline points="28 37 32 29 41 36 50 23"/><line x1="22" y1="49" x2="26" y2="41"/><polyline points="22 37 28 37 41 45 50 38"/>
            </g>
          </svg>
        </figure>

        <div class="line-height-xs">
          <p class="margin-top-xxxs">Компоненты <span class="text-sm color-contrast-medium">(комментариии, отзывы)</span></p>

        </div>
      </div>
    </div>

    <div class="link-card__footer margin-top-auto border-top border-contrast-lower">
      <p class="text-sm">Перейти</p>

      <div>
        <svg class="icon icon--sm" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12" /><polyline points="15 6 21 12 15 18"/></g></svg>
      </div>
    </div>
  </a>

  <a class="link-card flex flex-column bg radius-md col-6@sm col-4@lg" href="{{ route('pages') }}" aria-label="Link label">
    <div class="padding-md">
      <div class="flex flex-wrap gap-xs items-center">
        <figure>
          <svg class="block color-accent" width="72" height="72" viewBox="0 0 72 72">
            <circle fill="currentColor" opacity="0.15" cx="36" cy="36" r="36"/>
            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
              <polyline points="28 37 32 29 41 36 50 23"/><line x1="22" y1="49" x2="26" y2="41"/><polyline points="22 37 28 37 41 45 50 38"/>
            </g>
          </svg>
        </figure>

        <div class="line-height-xs">
          <p class="margin-top-xxxs">Страницы <span class="text-sm color-contrast-medium">(браслеты, рейтинги)</span></p>

        </div>
      </div>
    </div>

    <div class="link-card__footer margin-top-auto border-top border-contrast-lower">
      <p class="text-sm">Перейти</p>

      <div>
        <svg class="icon icon--sm" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12" /><polyline points="15 6 21 12 15 18"/></g></svg>
      </div>
    </div>
  </a>

  <a class="link-card flex flex-column bg radius-md col-6@sm col-4@lg" href="{{ route('settings') }}" aria-label="Link label">
    <div class="padding-md">
      <div class="flex flex-wrap gap-xs items-center">
        <figure>
          <svg class="block color-accent" width="72" height="72" viewBox="0 0 72 72">
            <circle fill="currentColor" opacity="0.15" cx="36" cy="36" r="36"/>
            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
              <polyline points="28 37 32 29 41 36 50 23"/><line x1="22" y1="49" x2="26" y2="41"/><polyline points="22 37 28 37 41 45 50 38"/>
            </g>
          </svg>
        </figure>

        <div class="line-height-xs">
          <p class="margin-top-xxxs">Компоненты админки</p>

        </div>
      </div>
    </div>

    <div class="link-card__footer margin-top-auto border-top border-contrast-lower">
      <p class="text-sm">Перейти</p>

      <div>
        <svg class="icon icon--sm" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12" /><polyline points="15 6 21 12 15 18"/></g></svg>
      </div>
    </div>
  </a>
</div>
@endsection