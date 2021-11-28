@extends('admin.layouts.base')

@section('content')

<form class="form-template-v3" method="POST" action="{{ route('specs.update', ['spec' => $spec->id]) }}">
    @csrf
    @method('PUT')
    <fieldset class="margin-bottom-md padding-bottom-md border-bottom">
      <div class="text-component margin-bottom-md text-center">
        <h2>Изменить характеристику</h2>
            <p>Внимание! Изменени характеристики затронет только товары, созданные после этого изменения. Товары, у которых характеристики уже указаны - затронуты не будут. Во избежании ошибок редактируйте только те характеристики, которые еще не использовались в товарах, либо после изменения пройдтиесь по всем товарам и вновь измените выбранную характеристику.</p>
      </div>

      <div class="grid gap-xxs margin-bottom-xs">
        <div class="col-6@md">
          <label class="form-label margin-bottom-xxxs" for="name">Название характеристики</label>

          <div class="select">
            <select class="select__input btn btn--subtle" name="name" id="name">
                <option value="display_tech" {{ $spec->name == 'display_tech' ? 'selected' : '' }}>Технология дисплея</option>
                <option value="sensors" {{ $spec->name == 'sensors' ? 'selected' : '' }}>Датчики</option>
                <option value="country" {{ $spec->name == 'country' ? 'selected' : '' }}>Страна</option>
                <option value="material" {{ $spec->name == 'material' ? 'selected' : '' }}>Материал</option>
                <option value="colors" {{ $spec->name == 'colors' ? 'selected' : '' }}>Цвета</option>
                <option value="monitoring" {{ $spec->name == 'monitoring' ? 'selected' : '' }}>Мониторинг</option>
                <option value="training_modes" {{ $spec->name == 'training_modes' ? 'selected' : '' }}>Тренировочные режимы</option>
                <option value="type_battery" {{ $spec->name == 'type_battery' ? 'selected' : '' }}>Тип аккумулятора</option>
                <option value="notifications" {{ $spec->name == 'notifications' ? 'selected' : '' }}>Уведомления</option>
                <option value="phone_calls" {{ $spec->name == 'phone_calls' ? 'selected' : '' }}>Телефонные звонки</option>
                <option value="bluetooth_versions" {{ $spec->name == 'bluetooth_versions' ? 'selected' : '' }}>Версии Bluetooth</option>
                <option value="interfaces" {{ $spec->name == 'other_interfaces' ? 'selected' : '' }}>Другие интерфейсы</option>
                <option value="protection_stands" {{ $spec->name == 'protection_stands' ? 'selected' : '' }}>Стандарты защиты</option>
                <option value="charger" {{ $spec->name == 'charger' ? 'selected' : '' }}>Зарядное устройство</option>
                <option value="terms_of_use" {{ $spec->name == 'terms_of_use' ? 'selected' : '' }}>Допустимые условия использования</option>
                <option value="compatibility" {{ $spec->name == 'compatibility' ? 'selected' : '' }}>Совместимость</option>
            </select>

            <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><polyline points="1 5 8 12 15 5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
          </div>



          <label class="form-label margin-bottom-xxxs" for="device">Выбрать устройство:</label>

          <div class="select">
            <select class="select__input btn btn--subtle" name="device" id="device">
                <option value="bracelet" @if ($spec->device == 'bracelet') selected @endif>Фитнес-браслет</option>
                <option value="watch" @if ($spec->device == 'watch') selected @endif>Смарт-часы</option>
                <option value="pulseoxi" @if ($spec->device == 'pulseoxi') selected @endif>Пульсоксиметр</option>
            </select>

            <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><polyline points="1 5 8 12 15 5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
          </div>


            {{-- Add specs --}}
    <section class="margin-bottom-md">
      <div class="text-component">
        <h4>Значения</h4>
      </div>
    <div class="js-repeater" data-repeater-input-name="allvalues[n]">
        <div class="js-repeater__list">
          {{-- Используем функцию forelse, чтобы при отсутствии связей вывести пустую форму --}}
          @forelse ($spec->value as $key => $value)
          <div class="grid gap-x-sm margin-y-md border radius-md padding-sm js-repeater__item">
            <div class="col-6@md">
              <input class="form-control" type="text" name="allvalues[{{ $loop->index }}][value]" id="allvalues[{{ $loop->index }}][value]" placeholder="Значение" value="{{ $key }}">

            </div>
            <div class="col-6@md">
                <input class="form-control" type="text" name="allvalues[{{ $loop->index }}][slug]" id="allvalues[{{ $loop->index }}][slug]" placeholder="slug" value="{{ $value }}">
            </div>
           
            <div class="col-1@md">
              <button class="btn btn--subtle padding-x-xs col-content js-repeater__remove btn--accent" type="button">
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
        
          {{-- Пустая форма при отсутствии связей --}}
          @empty
          <div class="grid gap-x-sm margin-y-md border radius-md padding-sm js-repeater__item">
            <div class="col-6@md">
              <input class="form-control" type="text" name="allvalues[0][value]" id="allvalues[0][value]" placeholder="Значение">

            </div>
            <div class="col-6@md">
                <input class="form-control" type="text" name="allvalues[0][slug]" id="allvalues[0][slug]" placeholder="slug">
            </div>
           
            <div class="col-1@md">
              <button class="btn btn--subtle padding-x-xs col-content js-repeater__remove btn--accent" type="button">
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
        <button class="btn btn--primary width-100% margin-top-xs js-repeater__add" type="button">+ Добавить значение</button>
      </div>
    </section>
      
    {{-- End add specs --}}


         
        </div>

          <div class="col-6@md">

          </div>
      </div>
    </fieldset>

    <div class="text-right">
      <button type="submit" class="btn btn--primary">Отправить</button>
    </div>
  </form>
@endsection

@section('scripts')

@parent

@endsection

