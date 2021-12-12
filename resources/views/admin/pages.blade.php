@extends('admin.layouts.base')

@section('content')

<div class="bg radius-md padding-sm margin-bottom-sm border-dashed border-2 border">
    {{ Breadcrumbs::render('pages') }}
    </div>

      <div class="grid gap-sm">
        <a class="link-card flex flex-column bg radius-md col-6@sm col-4@lg" href="{{ route('bracelets.index') }}" aria-label="Link label">
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
                <p class="text-lg font-semibold color-contrast-higher">{{ count($bracelets) }}</p>
                <p class="color-contrast-medium margin-top-xxxs">Каталог браслетов</p>
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

        <a class="link-card flex flex-column bg radius-md col-6@sm col-4@lg" href="{{ route('ratings.index') }}" aria-label="Link label">
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
                  <p class="text-lg font-semibold color-contrast-higher">{{ count($ratings) }}</p>
                  <p class="color-contrast-medium margin-top-xxxs">Рейтинги</p>
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


        <a class="link-card flex flex-column bg radius-md col-6@sm col-4@lg" href="{{ route('posts.index') }}" aria-label="Link label">
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
                <p class="text-lg font-semibold color-contrast-higher">{{ count($posts) }}</p>
                <p class="color-contrast-medium margin-top-xxxs">Блог</p>
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