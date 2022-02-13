<div>
    <section class="padding-y-md">
<div class="container max-width-lg">
  <div class="text-component text-center margin-bottom-lg">
      <h1>Каталог фитнес-браслетов</h1>
  </div>

    <div class="margin-top-sm grid shadow-sm padding-sm border radius-md">

<div class="col-3@md col-6">
  <div class="text-sm margin-top-xxxs">Рейтинг:</div>
    <ul class="text-sm">
        <li>
            <input class="radio radio--bg" type="radio" name="radio-5" id="radio-5" wire:model="min_rating" value="7">
            <label for="radio-5">Более <span class="text-bold">7</span>&#9733;</label>
        </li>

        <li>
            <input class="radio radio--bg" type="radio" wire:model="min_rating" name="radio-6" id="radio-6" value="8">
            <label for="radio-6">Более <span class="text-bold">8</span>&#9733;</label>
        </li>

        <li>
            <input class="radio radio--bg" wire:model="min_rating" type="radio" name="radio-7" id="radio-7" value="9">
            <label for="radio-7">Более <span class="text-bold">9</span>&#9733;</label>
        </li>
    </ul>
</div>

<div class="col-3@md col-6">
    <div class="text-sm margin-top-xxxs">Защита:</div>
    <ul class="text-sm">
      <li>
        <input class="radio radio--bg" type="radio" name="radio-button" id="radio-1" wire:model="protect_stand" value="high">
        <label for="radio-1">Высокая</label>
        <p class="text-xs color-contrast-medium x-iq">Плавание, дождь, пыль</p>
      </li>

      <li>
        <input class="radio radio--bg" type="radio" wire:model="protect_stand" name="radio-button" id="radio-2" value="medium">
        <label for="radio-2">Средняя</label>
        <p class="text-xs color-contrast-medium x-iq">Мытье рук, пыль</p>
      </li>

    </ul>
</div>

    <div class="col-3@md col-6">
        <div class="text-sm margin-top-xxxs">Цена:</div>
            <ul class="text-sm">
                <li>
                    <input class="radio radio--bg" wire:model="max_price" type="radio" name="radio-8" id="radio-8" value="3000">
                    <label for="radio-8">До 3 000 руб.</label>
                </li>
                <li>
                    <input class="radio radio--bg" type="radio" name="radio-9" id="radio-9" wire:model="max_price" value="5000">
                    <label for="radio-9">До 5 000 руб.</label>
                </li>

                <li>
                    <input class="radio radio--bg" type="radio" wire:model="max_price" name="radio-10" id="radio-10" value="7000">
                    <label for="radio-10">До 7 000 руб.</label>
                </li>
            </ul>
    </div>


            <div class="col-3@md col-6">
                <div class="text-sm margin-top-xxxs">Совместимость:</div>

                <ul class="text-sm">

                    <li>
                        <input class="radio radio--bg" type="radio" name="radio-11" id="radio-11" wire:model="compatibility" value="Android">
                        <label for="radio-11">Android</label>
                    </li>

                    <li>
                        <input class="radio radio--bg" type="radio" wire:model="compatibility" name="radio-12" id="radio-12" value="iOS">
                        <label for="radio-12">iOS</label>
                    </li>

                </ul>
            </div>

            <button wire:click.prevent="clearAllFilter()">Сбросить фильтры</button>

            </div>
            <div class="shadow-sm padding-sm border radius-md margin-top-sm text-sm">
                <div class="grid">
                    <div class="col-6">
                        <ul>
                            <li class="margin-bottom-sm">
                                <input class="checkbox" type="checkbox" name="heart_rate" id="heart_rate"  wire:model="heart_rate">
                                <label for="heart_rate">Постоянное измерение пульса</label>
                            </li>
                            <li class="margin-bottom-sm">
                                <input class="checkbox" type="checkbox" name="blood_oxy" id="blood_oxy"  wire:model="blood_oxy">
                                <label for="blood_oxy">Измерение кислорода в крови</label>
                            </li>
                            <li class="margin-bottom-sm">
                                <input class="checkbox" type="checkbox" name="blood_pressure" id="blood_pressure"  wire:model="blood_pressure">
                                <label for="blood_pressure">Измерение артериального давления</label>
                            </li>
                            <li class="margin-bottom-sm">
                                <input class="checkbox" type="checkbox" name="stress" id="stress"  wire:model="stress">
                                <label for="stress">Измерение стресса</label>
                            </li>
                            <li class="margin-bottom-sm">
                                <input class="checkbox" type="checkbox" name="smart_alarm" id="smart_alarm"  wire:model="smart_alarm">
                                <label for="smart_alarm">Умный будильник</label>
                            </li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul>
                            <li class="margin-bottom-sm">
                                <input class="checkbox" type="checkbox" name="player_control" id="player_control"  wire:model="player_control">
                                <label for="player_control">Управление плеером</label>
                            </li>
                            <li class="margin-bottom-sm">
                                <input class="checkbox" type="checkbox" name="send_messages" id="send_messages"  wire:model="send_messages">
                                <label for="send_messages">Отправка сообщений</label>
                            </li>
                            <li class="margin-bottom-sm">
                                <input class="checkbox" type="checkbox" name="disp_aod" id="disp_aod"  wire:model="disp_aod">
                                <label for="disp_aod">Always on Display (AoD)</label>
                            </li>
                            <li class="margin-bottom-sm">
                                <input class="checkbox" type="checkbox" name="gps" id="gps"  wire:model="gps">
                                <label for="gps">GPS</label>
                            </li>
                            <li class="margin-bottom-sm">
                                <input class="checkbox" type="checkbox" name="nfc" id="nfc"  wire:model="nfc">
                                <label for="nfc">NFC</label>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>



                <div class="select margin-top-sm">
                <select class="select__input btn btn--subtle" name="brand"  wire:model="brand" id="select-this">
                    <option value="">Выбрать бренд</option>
                    @foreach ($brands as $v => $k)
                    <option value="{{ $k }}">{{ $v }}</option>
                    @endforeach
                </select>

                <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><polyline points="1 5 8 12 15 5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                </div>

<section>
    {{-- <div class="grid gap-sm text-sm border padding-sm">
        <div class="col-3@md">

            <label class="form-label margin-bottom-xxxs text-bold" for="brand">Бренд:</label>
                <div class="select">
                    <select class="select__input form-control" name="brand" id="brand" wire:model="brand">
                        <option value="">Любой</option>
                        @foreach ($brands as $v => $k)
                           <option value="{{ $k }}">{{ $v }}</option>
                        @endforeach
                    </select>

                    <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16">
                        <g stroke-width="1" stroke="currentColor">
                            <polyline fill="none" stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-miterlimit="10"
                                points="15.5,4.5 8,12 0.5,4.5 "></polyline>
                        </g>
                    </svg>
                </div>


           <legend class="form-legend">Рейтинг</legend>

                <ul class="flex flex-column gap-xxxs">
                <li>
                    <input class="radio radio--bg" wire:model="min_rating" type="radio" name="radio-4" id="radio-4" value="">
                    <label for="radio-4">Не важно</label>
                </li>
                <li>
                    <input class="radio radio--bg" type="radio" name="radio-5" id="radio-5" wire:model="min_rating" value="7">
                    <label for="radio-5">Более <span class="text-bold">7</span>&#9733;</label>
                </li>

                <li>
                    <input class="radio radio--bg" type="radio" wire:model="min_rating" name="radio-6" id="radio-6" value="8">
                    <label for="radio-6">Более <span class="text-bold">8</span>&#9733;</label>
                </li>

                <li>
                    <input class="radio radio--bg" wire:model="min_rating" type="radio" name="radio-7" id="radio-7" value="9">
                    <label for="radio-7">Более <span class="text-bold">9</span>&#9733;</label>
                </li>

                </ul>


        </div>
        <div class="col-3@md">
            <fieldset>

    <legend class="form-legend">Защита</legend>

    <ul class="flex flex-column gap-xxxs">
      <li>
        <input class="radio radio--bg" type="radio" name="radio-button" id="radio-1" wire:model="protect_stand" value="high">
        <label for="radio-1">Высокая</label>
        <p class="text-xs color-contrast-medium x-iq">Плавание, дождь, пыль</p>
      </li>

      <li>
        <input class="radio radio--bg" type="radio" wire:model="protect_stand" name="radio-button" id="radio-2" value="medium">
        <label for="radio-2">Средняя</label>
        <p class="text-xs color-contrast-medium x-iq">Мытье рук, пыль</p>
      </li>

      <li>
        <input class="radio radio--bg" wire:model="protect_stand" type="radio" name="radio-button" id="radio-3" value="">
        <label for="radio-3">Любая</label>
      </li>
    </ul>
              </fieldset>


              <fieldset>
                <legend class="form-legend">Цена:</legend>

                <ul class="flex flex-column gap-xxxs">
                <li>
                    <input class="radio radio--bg" wire:model="max_price" type="radio" name="radio-8" id="radio-8" value="3000">
                    <label for="radio-8">До 3 000 руб.</label>
                </li>
                <li>
                    <input class="radio radio--bg" type="radio" name="radio-9" id="radio-9" wire:model="max_price" value="5000">
                    <label for="radio-9">До 5 000 руб.</label>
                </li>

                <li>
                    <input class="radio radio--bg" type="radio" wire:model="max_price" name="radio-10" id="radio-10" value="7000">
                    <label for="radio-10">До 7 000 руб.</label>
                </li>

                <li>
                    <input class="radio radio--bg" wire:model="max_price" type="radio" name="radio-11" id="radio-11" value="">
                    <label for="radio-11">Не важно</label>
                </li>

                </ul>
            </fieldset>
        </div>

        <div class="col-3@md">
            <ul class="flex flex-column gap-xxxs">
               <li>
                <input class="checkbox" type="checkbox" name="heart_rate" id="heart_rate"  wire:model="heart_rate">
                <label for="heart_rate">Постоянное измерение пульса</label>
               </li>
               <li>
                <input class="checkbox" type="checkbox" name="blood_oxy" id="blood_oxy"  wire:model="blood_oxy">
                <label for="blood_oxy">Измерение кислорода в крови</label>
               </li>
               <li>
                <input class="checkbox" type="checkbox" name="blood_pressure" id="blood_pressure"  wire:model="blood_pressure">
                <label for="blood_pressure">Измерение артериального давления</label>
               </li>
               <li>
                <input class="checkbox" type="checkbox" name="smart_alarm" id="smart_alarm"  wire:model="smart_alarm">
                <label for="smart_alarm">Умный будильник</label>
               </li>
               <li>
                <input class="checkbox" type="checkbox" name="gps" id="gps"  wire:model="gps">
                <label for="gps">GPS</label>
               </li>
               <li>
                <input class="checkbox" type="checkbox" name="nfc" id="nfc"  wire:model="nfc">
                <label for="nfc">NFC</label>
               </li>

            </ul>
        </div>

        <div class="col-3@md">
            <span class="text-lg">Всего найдено: <span class="text-bold">{{ $bracelets->total() }} {{ trans_choice('результат|результата|результатов',$bracelets->total()) }}</span></span>
        </div>
    </div> --}}


    <span class="text-lg">Всего найдено: <span class="text-bold">{{ $bracelets->total() }} {{ trans_choice('результат|результата|результатов',$bracelets->total()) }}</span></span>
<div class="padding-y-md padding-0@md">

            @if (request() != '')
            <ul class="flex flex-wrap gap-xxs">

                 <div class="margin-y-md">
                    <ul class="flex flex-wrap gap-xxs">

                    @if ($heart_rate != '')
                    <li>
                        <span class="chip text-sm">
                        <i class="chip__label">Постоянное измерение пульса</i>

                        <button class="chip__btn"  wire:click.prevent="clearFilter(`heart_rate`)">
                            <svg class="icon" viewBox="0 0 12 12"><title>Delete attribute</title><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><line x1="3" y1="3" x2="9" y2="9"/><line x1="9" y1="3" x2="3" y2="9"/></g></svg>
                        </button>
                        </span>
                    </li>
                    @endif

                    @if ($blood_oxy != '')
                    <li>
                        <span class="chip text-sm">
                        <i class="chip__label">Измерение кислорода в крови</i>

                        <button class="chip__btn"  wire:click.prevent="clearFilter(`blood_oxy`)">
                            <svg class="icon" viewBox="0 0 12 12"><title>Delete attribute</title><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><line x1="3" y1="3" x2="9" y2="9"/><line x1="9" y1="3" x2="3" y2="9"/></g></svg>
                        </button>
                        </span>
                    </li>
                    @endif

                    @if ($blood_pressure != '')
                    <li>
                        <span class="chip text-sm">
                        <i class="chip__label">Измерение давления</i>

                        <button class="chip__btn"  wire:click.prevent="clearFilter(`blood_pressure`)">
                            <svg class="icon" viewBox="0 0 12 12"><title>Delete attribute</title><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><line x1="3" y1="3" x2="9" y2="9"/><line x1="9" y1="3" x2="3" y2="9"/></g></svg>
                        </button>
                        </span>
                    </li>
                    @endif

                    @if ($smart_alarm != '')
                    <li>
                        <span class="chip text-sm">
                        <i class="chip__label">Умный будильник</i>

                        <button class="chip__btn"  wire:click.prevent="clearFilter(`smart_alarm`)">
                            <svg class="icon" viewBox="0 0 12 12"><title>Delete attribute</title><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><line x1="3" y1="3" x2="9" y2="9"/><line x1="9" y1="3" x2="3" y2="9"/></g></svg>
                        </button>
                        </span>
                    </li>
                    @endif

                    @if ($gps != '')
                    <li>
                        <span class="chip text-sm">
                        <i class="chip__label">GPS</i>

                        <button class="chip__btn"  wire:click.prevent="clearFilter(`gps`)">
                            <svg class="icon" viewBox="0 0 12 12"><title>Delete attribute</title><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><line x1="3" y1="3" x2="9" y2="9"/><line x1="9" y1="3" x2="3" y2="9"/></g></svg>
                        </button>
                        </span>
                    </li>
                    @endif

                    @if ($nfc != '')
                    <li>
                        <span class="chip text-sm">
                          <i class="chip__label">NFC</i>

                          <button class="chip__btn"  wire:click.prevent="clearFilter(`nfc`)">
                            <svg class="icon" viewBox="0 0 12 12"><title>Delete attribute</title><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><line x1="3" y1="3" x2="9" y2="9"/><line x1="9" y1="3" x2="3" y2="9"/></g></svg>
                          </button>
                        </span>
                    </li>
                    @endif

                    @if ($stress != '')
                    <li>
                        <span class="chip text-sm">
                          <i class="chip__label">Измерение стресса</i>

                          <button class="chip__btn"  wire:click.prevent="clearFilter(`stress`)">
                            <svg class="icon" viewBox="0 0 12 12"><title>Delete attribute</title><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><line x1="3" y1="3" x2="9" y2="9"/><line x1="9" y1="3" x2="3" y2="9"/></g></svg>
                          </button>
                        </span>
                    </li>
                    @endif

                    @if ($send_messages != '')
                    <li>
                        <span class="chip text-sm">
                          <i class="chip__label">Отправка сообщений</i>

                          <button class="chip__btn"  wire:click.prevent="clearFilter(`send_messages`)">
                            <svg class="icon" viewBox="0 0 12 12"><title>Delete attribute</title><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><line x1="3" y1="3" x2="9" y2="9"/><line x1="9" y1="3" x2="3" y2="9"/></g></svg>
                          </button>
                        </span>
                    </li>
                    @endif

                    @if ($player_control != '')
                    <li>
                        <span class="chip text-sm">
                          <i class="chip__label">Управление плеером</i>

                          <button class="chip__btn"  wire:click.prevent="clearFilter(`player_control`)">
                            <svg class="icon" viewBox="0 0 12 12"><title>Delete attribute</title><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><line x1="3" y1="3" x2="9" y2="9"/><line x1="9" y1="3" x2="3" y2="9"/></g></svg>
                          </button>
                        </span>
                    </li>
                    @endif

                    @if ($disp_aod != '')
                    <li>
                        <span class="chip text-sm">
                          <i class="chip__label">Always on Display (AoD)</i>

                          <button class="chip__btn"  wire:click.prevent="clearFilter(`disp_aod`)">
                            <svg class="icon" viewBox="0 0 12 12"><title>Delete attribute</title><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><line x1="3" y1="3" x2="9" y2="9"/><line x1="9" y1="3" x2="3" y2="9"/></g></svg>
                          </button>
                        </span>
                    </li>
                    @endif

                    @if ($protect_stand != '')
                    <li>
                        <span class="chip text-sm chip--outline">
                          <i class="chip__label">@if ($protect_stand == 'high')
                             С высокой защитой
                          @else
                             С средней защитой
                          @endif</i>

                          <button class="chip__btn"  wire:click.prevent="clearFilter(`protect_stand`)">
                            <svg class="icon" viewBox="0 0 12 12"><title>Delete attribute</title><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><line x1="3" y1="3" x2="9" y2="9"/><line x1="9" y1="3" x2="3" y2="9"/></g></svg>
                          </button>
                        </span>
                    </li>
                    @endif

                    @if ($min_rating != '')
                    <li>
                        <span class="chip text-sm chip--outline">
                          <i class="chip__label">С рейтингом от {{ $min_rating }}  <svg class="icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M22.765 9.397a.676.676 0 00-.538-.453l-6.64-1.015-2.976-6.34c-.222-.474-.999-.474-1.222 0L8.413 7.93l-6.64 1.015a.674.674 0 00-.381 1.139l4.824 4.945-1.14 6.99a.673.673 0 00.992.699L12 19.439l5.931 3.278a.672.672 0 00.993-.699l-1.14-6.99 4.824-4.945a.675.675 0 00.157-.686z" fill="#ffc107"/><path d="M5.574 15.362l-1.267 7.767a.751.751 0 001.103.777L12 20.264l6.59 3.643a.748.748 0 001.103-.778l-1.267-7.767 5.36-5.494a.75.75 0 00-.423-1.265l-7.378-1.127L12.678.432c-.247-.526-1.11-.526-1.357 0L8.015 7.476.637 8.603a.75.75 0 00-.424 1.265zm3.063-6.464a.75.75 0 00.565-.422L12 2.515l2.798 5.96a.747.747 0 00.565.422l6.331.967-4.605 4.72a.75.75 0 00-.204.645l1.08 6.617-5.602-3.096a.755.755 0 00-.726 0l-5.602 3.096 1.08-6.617a.75.75 0 00-.204-.645l-4.605-4.72z"/></svg></i>

                          <button class="chip__btn"  wire:click.prevent="clearFilter(`min_rating`)">
                            <svg class="icon" viewBox="0 0 12 12"><title>Delete attribute</title><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><line x1="3" y1="3" x2="9" y2="9"/><line x1="9" y1="3" x2="3" y2="9"/></g></svg>
                          </button>
                        </span>
                    </li>
                    @endif

                    </ul>

                 </div>
            @endif

            <div class="circle-loader circle-loader--v5 margin-x-auto margin-top-xl" role="alert" wire:loading>
                <p class="circle-loader__label">Загрузка контента...</p>
                <div aria-hidden="true">
                <div class="circle-loader__shadow"></div>
                <div class="circle-loader__ball"></div>
                </div>
            </div>

            <div class="grid">
                @foreach ($bracelets as $bracelet)
                    @include('livewire.bracelets.index', ['bracelet' => $bracelet])
                @endforeach
            </div>
            {{ $bracelets->links('vendor.pagination.livewire') }}
          </div>
</section>

</div>
</section>

</div>



