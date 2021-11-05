@extends('admin.layouts.base')

@section('content')

<form class="form-template-v3" method="POST" action="{{ route('specs.store') }}">
    @csrf
    <fieldset class="margin-bottom-md padding-bottom-md border-bottom">
      <div class="text-component margin-bottom-md text-center">
        <h2>Добавить характеристику</h2>
            <p>Добавление характеристик товаров.</p>
      </div>

      <div class="grid gap-xxs margin-bottom-xs">
        <div class="col-6@md">
          <label class="form-label margin-bottom-xxxs" for="name">Название характеристики</label>

          <div class="select">
            <select class="select__input btn btn--subtle" name="name" id="name">
                <option value="Технология дисплея">Технология дисплея</option>
                <option value="Датчики">Датчики</option>
            </select>

            <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><polyline points="1 5 8 12 15 5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
          </div>



          <label class="form-label margin-bottom-xxxs" for="device">Выбрать устройство:</label>

          <div class="select">
            <select class="select__input btn btn--subtle" name="device" id="device">
                <option value="bracelet">Фитнес-браслет</option>
                <option value="watch">Смарт-часы</option>
                <option value="pulseoxi">Пульсоксиметр</option>
            </select>

            <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><polyline points="1 5 8 12 15 5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
          </div>



          <label class="form-label margin-bottom-xxs" for="value">Значение</label>
          <input class="form-control width-100%" type="text" name="value" id="value">

          <label class="form-label margin-bottom-xxs" for="slug">Slug</label>
          <input class="form-control width-100%" type="text" name="slug" id="slug">
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