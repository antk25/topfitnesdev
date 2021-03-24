<div>
<section class="padding-y-xl">
<div class="container max-width-lg">
  <div class="text-component text-center margin-bottom-lg">
      <h1>Каталог фитнес-браслетов</h1>
  </div>

<section>
    <div class="grid gap-sm text-sm border padding-sm">
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


            <ul class="flex flex-column gap-xxxs margin-y-sm">
               
               <li>
                <input class="checkbox" type="checkbox" name="disp_sens" id="disp_sens"  wire:model="disp_sens">
                <label for="disp_sens">Сенсорный дисплей</label>
               </li>
            </ul>

            <label class="form-label margin-bottom-xxxs text-bold" for="disp_tech">Технология дисплея:</label>
                <div class="select">
                    <select class="select__input form-control" name="disp_tech" id="disp_tech" wire:model="disp_tech">
                        <option value="">Любая</option>
                        <option value="AMOLED">AMOLED</option>
                        <option value="IPS">IPS</option>
                        <option value="TFT">TFT</option>
                        <option value="OLED">OLED</option>
                        <option value="LCD">LCD</option>
                        <option value="POLED">POLED</option>
                    </select>

                    <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16">
                        <g stroke-width="1" stroke="currentColor">
                            <polyline fill="none" stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-miterlimit="10"
                                points="15.5,4.5 8,12 0.5,4.5 "></polyline>
                        </g>
                    </svg>
                </div>
                
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
        <input class="radio radio--bg" type="radio" wire:model="protect_stand" name="radio-button" id="radio-2" value="middle">
        <label for="radio-2">Средняя</label>
        <p class="text-xs color-contrast-medium x-iq">Мытье рук, пыль</p>
      </li>

      <li>
        <input class="radio radio--bg" wire:model="protect_stand" type="radio" name="radio-button" id="radio-3" value="">
        <label for="radio-3">Любая</label>
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
    </div>
<div class="padding-y-md padding-0@md">

            @if (request() != '')
                 <div class="margin-y-md">
                    
                    {!! $heart_rate != '' ? '<span wire:click.prevent="clearFilter(`heart_rate`)" class="badge badge--primary-light text-sm margin-right-xs">Постоянное измерение пульса
                                                <svg class="icon icon--xxs margin-left-xxxs" viewBox="0 0 12 12" aria-hidden="true" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
                        <line x1="1" y1="1" x2="11" y2="11" />
                        <line x1="11" y1="1" x2="1" y2="11" /></svg>
                        </span>' : '' !!}
                    {!! $blood_oxy != '' ? '<span wire:click.prevent="clearFilter(`blood_oxy`)" class="badge badge--primary-light text-sm margin-right-xs">Измерение кислорода в крови
                                                <svg class="icon icon--xxs margin-left-xxxs" viewBox="0 0 12 12" aria-hidden="true" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
                        <line x1="1" y1="1" x2="11" y2="11" />
                        <line x1="11" y1="1" x2="1" y2="11" /></svg>
                        </span>' : '' !!}

                    {!! $blood_pressure != '' ? '<span wire:click.prevent="clearFilter(`blood_pressure`)" class="badge badge--primary-light text-sm margin-right-xs">Измерение давления
                        <svg class="icon icon--xxs margin-left-xxxs" viewBox="0 0 12 12" aria-hidden="true" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
                    <line x1="1" y1="1" x2="11" y2="11" />
                    <line x1="11" y1="1" x2="1" y2="11" /></svg>
                    </span>' : '' !!}

                    {!! $smart_alarm != '' ? '<span wire:click.prevent="clearFilter(`smart_alarm`)" class="badge badge--primary-light text-sm margin-right-xs">Умный будильник
                        <svg class="icon icon--xxs margin-left-xxxs" viewBox="0 0 12 12" aria-hidden="true" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
                    <line x1="1" y1="1" x2="11" y2="11" />
                    <line x1="11" y1="1" x2="1" y2="11" /></svg>
                    </span>' : '' !!}
                    {!! $gps != '' ? '<span wire:click.prevent="clearFilter(`gps`)" class="badge badge--primary-light text-sm margin-right-xs">GPS
                        <svg class="icon icon--xxs margin-left-xxxs" viewBox="0 0 12 12" aria-hidden="true" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
                    <line x1="1" y1="1" x2="11" y2="11" />
                    <line x1="11" y1="1" x2="1" y2="11" /></svg>
                    </span>' : '' !!}
                    {!! $nfc != '' ? '<span wire:click.prevent="clearFilter(`nfc`)" class="badge badge--primary-light text-sm margin-right-xs">NFC
                        <svg class="icon icon--xxs margin-left-xxxs" viewBox="0 0 12 12" aria-hidden="true" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
                    <line x1="1" y1="1" x2="11" y2="11" />
                    <line x1="11" y1="1" x2="1" y2="11" /></svg>
                    </span>' : '' !!}
                    
                    @if ($protect_stand == 'middle')
                    <span wire:click.prevent="clearFilter(`protect_stand`)" class="badge badge--primary-light text-sm margin-right-xs">Средняя защита
                        <svg class="icon icon--xxs margin-left-xxxs" viewBox="0 0 12 12" aria-hidden="true" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
                            <line x1="1" y1="1" x2="11" y2="11" />
                            <line x1="11" y1="1" x2="1" y2="11" /></svg>
                    </span>
                    @elseif ($protect_stand == 'high')
                    <span wire:click.prevent="clearFilter(`protect_stand`)" class="badge badge--primary-light text-sm margin-right-xs">Высокая защита 
                        <svg class="icon icon--xxs margin-left-xxxs" viewBox="0 0 12 12" aria-hidden="true" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
                        <line x1="1" y1="1" x2="11" y2="11" />
                        <line x1="11" y1="1" x2="1" y2="11" /></svg>
                    </span>
                    @endif 

                    @if ($disp_tech != '')
                    <span wire:click.prevent="clearFilter(`disp_tech`)" class="badge badge--primary-light text-sm margin-right-xs">{{ $disp_tech }}
                        <svg class="icon icon--xxs margin-left-xxxs" viewBox="0 0 12 12" aria-hidden="true" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
                            <line x1="1" y1="1" x2="11" y2="11" />
                            <line x1="11" y1="1" x2="1" y2="11" /></svg>
                    </span>
                    @endif
                    

                 </div>
            @endif
            <div class="grid grid-gap-md row">
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

