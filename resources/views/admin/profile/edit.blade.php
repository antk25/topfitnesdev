@extends('admin.layouts.base')

@section('content')
<div class="margin-bottom-md">
          <h1 class="text-lg">Настройки профиля</h1>
        </div>

        <div class="margin-bottom-md">
          <nav class="s-tabs">
            <ul class="s-tabs__list">
              {{-- <li><a class="{{ (request()->segment(3) == 'edit') ? 's-tabs__link s-tabs__link--current' : 's-tabs__link' }}" href="{{ route('admin.profile.edit') }}">Профиль</a></li>
              <li><a class="{{ (request()->segment(3) == 'password') ? 's-tabs__link s-tabs__link--current' : 's-tabs__link' }}" href="{{ route('admin.profile.password') }}">Пароль</a></li> --}}
            </ul>
          </nav>
        </div>

        <div class="bg radius-md shadow-xs">
            <form method="POST" action="{{ route('update-user-profile', ['user' => auth()->user()]) }}" enctype="multipart/form-data">
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

             {{-- Добавление контактов --}}
            <section class="margin-bottom-md">
              <div class="text-component">
                <h4>Добавить контакты</h4>
              </div>
              <div class="js-repeater" data-repeater-input-name="allcontacts[n]">
                <div class="js-repeater__list">
                  @forelse ($user->contacts as $k => $v)
                  <div class="grid grid-col-6 gap-x-sm margin-y-md border radius-md padding-sm js-repeater__item">
                    <div class="col-3@md">
                      <div class="select margin-bottom-xxs">
                        <select class="select__input form-control" name="allcontacts[{{ $loop->index }}][contacts]" id="allcontacts[0{{ $loop->index }}][contacts]"
                                class="form-control">
                            <option value="">-- Выбрать контакт --</option>
                                <option value="whatsapp" @if($k == 'whatsapp')selected @endif>WhatsApp</option>
                                <option value="telegram" @if($k == 'telegram')selected @endif>Telegram</option>
                                <option value="facebook" @if($k == 'facebook')selected @endif>Facebook</option>
                                <option value="twitter" @if($k == 'twitter')selected @endif>Twitter</option>
                                <option value="vk" @if($k == 'vk')selected @endif>Vkontakte</option>
                        </select>

                          <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="15.5,4.5 8,12 0.5,4.5 "></polyline></g></svg>
                        </div>
                    </div>
                    <div class="col-2@md">
                      <input class="form-control width-100%" type="text" name="allcontacts[{{ $loop->index }}][value]" id="allcontacts[{{ $loop->index }}][value]" placeholder="Введите аккаунт" value="{{ $v }}">
                    </div>


                    <div class="col-1@md">
                      <button class="btn width-100% margin-y-sm btn--subtle padding-x-xs col-content js-repeater__remove btn--accent" type="button">
                        <svg class="icon" viewBox="0 0 20 20">
                          <title>Remove item</title>

                          <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                            <line x1="1" y1="5" x2="19" y2="5"/>
                            <path d="M7,5V2A1,1,0,0,1,8,1h4a1,1,0,0,1,1,1V5"/>
                            <path d="M16,8l-.835,9.181A2,2,0,0,1,13.174,19H6.826a2,2,0,0,1-1.991-1.819L4,8"/>
                          </g>
                        </svg>
                      </button>
                    </div>

                  </div>
                  @empty
                  <div class="grid grid-col-6 gap-x-sm margin-y-md border radius-md padding-sm js-repeater__item">
                    <div class="col-3@md">
                      <div class="select margin-bottom-xxs">
                        <select class="select__input form-control" name="allcontacts[0][contacts]" id="allcontacts[0][contacts]"
                                class="form-control">
                            <option value="">-- Выбрать контакт --</option>
                                <option value="whatsapp">WhatsApp</option>
                                <option value="telegram">Telegram</option>
                                <option value="facebook">Facebook</option>
                                <option value="twitter">Twitter</option>
                                <option value="vk">Vkontakte</option>
                        </select>

                          <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="15.5,4.5 8,12 0.5,4.5 "></polyline></g></svg>
                        </div>
                    </div>
                    <div class="col-2@md">
                      <input class="form-control width-100%" type="text" name="allcontacts[0][value]" id="allcontacts[0][value]" placeholder="Введите аккаунт">
                    </div>


                    <div class="col-1@md">
                      <button class="btn width-100% margin-y-sm btn--subtle padding-x-xs col-content js-repeater__remove btn--accent" type="button">
                        <svg class="icon" viewBox="0 0 20 20">
                          <title>Remove item</title>

                          <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                            <line x1="1" y1="5" x2="19" y2="5"/>
                            <path d="M7,5V2A1,1,0,0,1,8,1h4a1,1,0,0,1,1,1V5"/>
                            <path d="M16,8l-.835,9.181A2,2,0,0,1,13.174,19H6.826a2,2,0,0,1-1.991-1.819L4,8"/>
                          </g>
                        </svg>
                      </button>
                    </div>

                  </div>
                  @endforelse
                </div>
                <button class="btn btn--primary width-100% margin-top-xs js-repeater__add" type="button">+ Добавить контакт</button>
              </div>
            </section>
            {{-- Конец добавления контактов --}}

            <div class="border-top border-contrast-lower padding-md text-right">
              <button type="submit" class="btn btn--primary btn--md">Сохранить</button>
            </div>
          </form>
        </div>
        @endsection