
@extends('admin.layouts.base')

@section('content')
<div class="margin-bottom-md">
          <h1 class="text-lg">Настройки профиля</h1>
        </div>

        <div class="margin-bottom-md">
          <nav class="s-tabs">
            <ul class="s-tabs__list">
              <li><a class="{{ (request()->segment(3) == 'edit') ? 's-tabs__link s-tabs__link--current' : 's-tabs__link' }}" href="{{ route('admin.profile.edit') }}">Профиль</a></li>
              <li><a class="{{ (request()->segment(3) == 'password') ? 's-tabs__link s-tabs__link--current' : 's-tabs__link' }}" href="{{ route('admin.profile.password') }}">Пароль</a></li>
            </ul>
          </nav>
        </div>

        <div class="bg radius-md shadow-xs">
            @if (session('status') == "password-updated")
        <div class="alert alert--success alert--is-visible padding-sm radius-md js-alert" role="alert">
            <div class="flex items-center justify-between">
              <div class="flex items-center">
                <svg class="icon icon--sm alert__icon margin-right-xxs" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="M12,0A12,12,0,1,0,24,12,12.035,12.035,0,0,0,12,0ZM10,17.414,4.586,12,6,10.586l4,4,8-8L19.414,8Z"></path>
                </svg>

                <p class="text-sm">Пароль успешно обновлен!</p>
              </div>

              <button class="reset alert__close-btn margin-left-sm js-alert__close-btn js-tab-focus">
                <svg class="icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                  <title>Close alert</title>
                  <line x1="3" y1="3" x2="17" y2="17" />
                  <line x1="17" y1="3" x2="3" y2="17" />
                </svg>
              </button>
            </div>
          </div>
        @endif

        <form method="POST" action="{{ route('user-password.update') }}">
            @csrf
        @method('PUT')
          <div class="padding-md">
            <!-- old password -->
            <fieldset class="margin-bottom-xl">
              <legend class="form-legend margin-bottom-md">Текущий пароль</legend>

              <div class="margin-bottom-sm">
                <div class="grid gap-xxs">
                  <div class="col-3@lg">
                    <label class="inline-block text-sm padding-top-xs@lg" for="current_password">{{ __('Current Password') }}</label>
                  </div>

                  <div class="col-6@lg">
                    <div class="password js-password ">
                      <input class="password__input form-control width-100% js-password__input" type="password" name="current_password" id="current_password"required @error('current_password', 'updatePassword') aria-invalid="true" @enderror autocomplete="current_password" autofocus>

                      <button class="password__btn flex flex-center js-password__btn js-tab-focus">
                        <span class="password__btn-label" aria-label="Show password" title="Show password">
                          <svg class="icon block" viewBox="0 0 20 20"><path d="M1,10s4-6,9-6,9,6,9,6-4,6-9,6S1,10,1,10Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/><circle fill="currentColor" cx="10" cy="10" r="3"/></svg>
                        </span>

                        <span class="password__btn-label" aria-label="Hide password" title="Hide password">
                          <svg class="icon block" viewBox="0 0 20 20"><circle fill="currentColor" cx="10" cy="10" r="3"/><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><line x1="2" y1="18" x2="18" y2="2" /><path d="M5.511,14.489A18.132,18.132,0,0,1,1,10s4-6,9-6a8.276,8.276,0,0,1,4.489,1.511"/><path d="M17,7.606A18.257,18.257,0,0,1,19,10s-4,6-9,6a6.383,6.383,0,0,1-1-.079"/></g></svg>
                        </span>
                      </button>
                    </div>
                    @error('current_password', 'updatePassword')
                    <div role="alert" class="bg-error bg-opacity-20% padding-xs radius-md text-sm color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
                    @enderror
                  </div>
                </div>
              </div>
            </fieldset>

            <!-- new password -->
            <fieldset class="margin-bottom-md">
              <legend class="form-legend margin-bottom-md">Новый пароль</legend>

              <div class="margin-bottom-sm">
                <div class="grid gap-xxs">
                  <div class="col-3@lg">
                    <label class="inline-block text-sm padding-top-xs@lg" for="password">Новый пароль</label>
                  </div>

                  <div class="col-6@lg">
                    <div class="password js-password ">
                      <input class="password__input form-control width-100% js-password__input" type="password" name="password" id="password" @error('password', 'updatePassword') aria-invalid="true" @enderror autocomplete="new-password">

                      <button class="password__btn flex flex-center js-password__btn js-tab-focus">
                        <span class="password__btn-label" aria-label="Show password" title="Show password">
                          <svg class="icon block" viewBox="0 0 20 20"><path d="M1,10s4-6,9-6,9,6,9,6-4,6-9,6S1,10,1,10Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/><circle fill="currentColor" cx="10" cy="10" r="3"/></svg>
                        </span>

                        <span class="password__btn-label" aria-label="Hide password" title="Hide password">
                          <svg class="icon block" viewBox="0 0 20 20"><circle fill="currentColor" cx="10" cy="10" r="3"/><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><line x1="2" y1="18" x2="18" y2="2" /><path d="M5.511,14.489A18.132,18.132,0,0,1,1,10s4-6,9-6a8.276,8.276,0,0,1,4.489,1.511"/><path d="M17,7.606A18.257,18.257,0,0,1,19,10s-4,6-9,6a6.383,6.383,0,0,1-1-.079"/></g></svg>
                        </span>
                      </button>
                    </div>
                    @error('password', 'updatePassword')
                        <div role="alert" class="bg-error bg-opacity-20% padding-xs radius-md text-sm color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
                    @enderror
                  </div>
                </div>
              </div>

              <div>
                <div class="grid gap-xxs">
                  <div class="col-3@lg">
                    <label class="inline-block text-sm padding-top-xs@lg" for="password_confirmation">Повторите новый пароль</label>
                  </div>

                  <div class="col-6@lg">
                    <div class="password js-password ">
                      <input class="password__input form-control width-100% js-password__input" type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password">

                      <button class="password__btn flex flex-center js-password__btn js-tab-focus">
                        <span class="password__btn-label" aria-label="Show password" title="Show password">
                          <svg class="icon block" viewBox="0 0 20 20"><path d="M1,10s4-6,9-6,9,6,9,6-4,6-9,6S1,10,1,10Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/><circle fill="currentColor" cx="10" cy="10" r="3"/></svg>
                        </span>

                        <span class="password__btn-label" aria-label="Hide password" title="Hide password">
                          <svg class="icon block" viewBox="0 0 20 20"><circle fill="currentColor" cx="10" cy="10" r="3"/><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><line x1="2" y1="18" x2="18" y2="2" /><path d="M5.511,14.489A18.132,18.132,0,0,1,1,10s4-6,9-6a8.276,8.276,0,0,1,4.489,1.511"/><path d="M17,7.606A18.257,18.257,0,0,1,19,10s-4,6-9,6a6.383,6.383,0,0,1-1-.079"/></g></svg>
                        </span>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </fieldset>
          </div>

          <div class="border-top border-contrast-lower padding-md text-right">
            <button class="btn btn--primary btn--md">{{ __('Reset Password') }}</button>
          </div>
        </form>
      </div>
        @endsection