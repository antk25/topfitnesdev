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
            <form method="POST" action="{{ route('user-profile-information.update') }}" enctype="multipart/form-data">
                @csrf
            @method('PUT')
            <div class="padding-md">
              <!-- basic form controls -->
              <fieldset class="margin-bottom-xl">
                <legend class="form-legend margin-bottom-md">Настройки профиля</legend>

                <!-- input text -->
                <div class="margin-bottom-sm">
                  <div class="grid gap-xxs">
                    <div class="col-3@lg">
                      <label class="inline-block text-sm padding-top-xs@lg" for="name">{{ __('Name') }}</label>
                    </div>

                    <div class="col-6@lg">
                      <input class="form-control width-100%" type="text" name="name" id="name" value="{{ old('name') ?? auth()->user()->name }}" required>
                    </div>
                  </div>
                  @error('name')
                    <div role="alert" class="bg-error bg-opacity-20% padding-xs radius-md text-sm color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
                  @enderror
                </div>

                <!-- input email -->
                <div class="margin-bottom-sm">
                  <div class="grid gap-xxs">
                    <div class="col-3@lg">
                      <label class="inline-block text-sm padding-top-xs@lg" for="email">{{ __('Email') }}</label>
                    </div>

                    <div class="col-6@lg">
                      <input class="form-control width-100%" type="email" name="email" id="email" value="{{ old('email') ?? auth()->user()->email }}">
                    </div>
                  </div>
                  @error('email')
                    <div role="alert" class="bg-error bg-opacity-20% padding-xs radius-md text-sm color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
                  @enderror
                </div>

                <!-- input avatar -->
                <div class="margin-bottom-sm">
                    <div class="file-upload inline-block">
                    <label for="avatar" class="file-upload__label btn btn--primary">
                      <span class="flex items-center">
                        <svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><g fill="none" stroke="currentColor" stroke-width="2"><path  stroke-linecap="square" stroke-linejoin="miter" d="M2 16v6h20v-6"></path><path stroke-linejoin="miter" stroke-linecap="butt" d="M12 17V2"></path><path stroke-linecap="square" stroke-linejoin="miter" d="M18 8l-6-6-6 6"></path></g></svg>

                        <span class="margin-left-xxs file-upload__text file-upload__text--has-max-width">Загрузить аватар</span>
                      </span>
                    </label>

                    <input type="file" class="file-upload__input" name="avatar" id="avatar">
                  </div>
                    @error('avatar')
                    <div role="alert" class="bg-error bg-opacity-20% padding-xs radius-md text-sm color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
                    @enderror
                  </div>



                <!-- textarea -->
                <div class="margin-bottom-sm">
                  <div class="grid gap-xxs">
                    <div class="col-3@lg">
                      <label class="inline-block text-sm padding-top-xs@lg" for="about">О себе</label>
                    </div>

                    <div class="col-6@lg">
                      <textarea class="form-control width-100%" name="about" id="about">{{ old('about') ?? auth()->user()->about }}</textarea>
                      <p class="text-xs color-contrast-medium margin-top-xxs">Напишите инфу о себе</p>
                    </div>
                  </div>
                  @error('about')
                    <div role="alert" class="bg-error bg-opacity-20% padding-xs radius-md text-sm color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
                  @enderror
                </div>

              </fieldset>

              <!-- choice tags -->
              <fieldset class="margin-bottom-md">
                <!-- input text -->
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                      <div class="col-3@lg">
                        <label class="inline-block text-sm padding-top-xs@lg" for="whatsapp">WhatsApp</label>
                      </div>

                      <div class="col-6@lg">
                        <input class="form-control width-100%" type="text" name="whatsapp" id="whatsapp" value="{{ old('whatsapp') ?? auth()->user()->whatsapp }}">
                      </div>
                    </div>
                    @error('whatsapp')
                      <div role="alert" class="bg-error bg-opacity-20% padding-xs radius-md text-sm color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
                    @enderror
                </div>


                <!-- input text -->
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                      <div class="col-3@lg">
                        <label class="inline-block text-sm padding-top-xs@lg" for="telegram">Telegram</label>
                      </div>

                      <div class="col-6@lg">
                        <input class="form-control width-100%" type="text" name="telegram" id="telegram" value="{{ old('telegram') ?? auth()->user()->telegram }}">
                      </div>
                    </div>
                    @error('telegram')
                      <div role="alert" class="bg-error bg-opacity-20% padding-xs radius-md text-sm color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
                    @enderror
                </div>

                <!-- input text -->
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                      <div class="col-3@lg">
                        <label class="inline-block text-sm padding-top-xs@lg" for="vk">Vkontakte</label>
                      </div>

                      <div class="col-6@lg">
                        <input class="form-control width-100%" type="text" name="vk" id="vk" value="{{ old('vk') ?? auth()->user()->vk }}">
                      </div>
                    </div>
                    @error('vk')
                      <div role="alert" class="bg-error bg-opacity-20% padding-xs radius-md text-sm color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
                    @enderror
                </div>

                <!-- input text -->
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                      <div class="col-3@lg">
                        <label class="inline-block text-sm padding-top-xs@lg" for="facebook">Facebook</label>
                      </div>

                      <div class="col-6@lg">
                        <input class="form-control width-100%" type="text" name="facebook" id="facebook" value="{{ old('facebook') ?? auth()->user()->facebook }}">
                      </div>
                    </div>
                    @error('facebook')
                      <div role="alert" class="bg-error bg-opacity-20% padding-xs radius-md text-sm color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
                    @enderror
                </div>
              </fieldset>
            </div>

            <div class="border-top border-contrast-lower padding-md text-right">
              <button type="submit" class="btn btn--primary btn--md">Сохранить</button>
            </div>
          </form>
        </div>
        @endsection