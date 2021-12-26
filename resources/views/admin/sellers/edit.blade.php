@extends('admin.layouts.base')

@section('content')

<div class="bg radius-md padding-sm margin-bottom-sm border-dashed border-2 border">
    {{ Breadcrumbs::render('admin_seller', $seller) }}
  </div>

<form class="form-template-v3" method="POST" action="{{ route('sellers.update', ['seller' => $seller->id]) }}">
    @csrf
    <div class="bg radius-md shadow-xs padding-md margin-bottom-md">
    <fieldset>

      <div class="margin-bottom-xs">
        <div class="grid gap-xxs items-center@md">
          <div class="col-4@md">

          <label class="form-label" for="marketplace">Выбрать, если маркетплейс</label>

          </div>

          <div class="col-8@md">
            <div class="select">
            <select class="select__input btn btn--subtle" name="marketplace" id="marketplace">
                <option value="">Выбрать маркетплейс</option>
                <option value="aliexpress" @if($seller->marketplace == 'aliexpress') selected @endif>Aliexpress</option>
                <option value="ozon" @if($seller->marketplace == 'ozon') selected @endif>Ozone</option>
            </select>

            <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16"><polyline points="1 5 8 12 15 5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
            </div>
          </div>
        </div>
      </div>

      <div class="margin-bottom-xs">
        <div class="grid gap-xxs items-center@md">
          <div class="col-4@md">

         <label class="form-label" for="name">Название продавца</label>

          <p class="text-xs color-contrast-medium margin-top-xxs">Название магазина (если маркетплейс, то можно просто продавец 1, продавец 2. Выводится только, если это не маркетплейс)</p>
          </div>

          <div class="col-8@md">

          <input class="form-control width-100% @error('name') form-control--error @enderror" type="text" name="name" id="name" value="{{ $seller->name }}">

              @error('name')
              <div role="alert" class="bg-error bg-opacity-20% padding-xxxs radius-md text-xs color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
              @enderror


          </div>
        </div>
      </div>

      <div class="margin-bottom-xs">
        <div class="grid gap-xxs items-center@md">
          <div class="col-4@md">

            <label class="form-label" for="about">Описание:</label>
            <p class="text-xs color-contrast-medium margin-top-xxxxs">Опционально</p>

          </div>

          <div class="col-8@md">

          <textarea class="form-control width-100%" name="about" id="about">{{ $seller->about }}</textarea>

          </div>
        </div>
      </div>

    </fieldset>
    </div>

    <div class="text-right">
      <button type="submit" class="btn btn--primary">Сохранить</button>
    </div>
  </form>

@endsection

@section('scripts')
@parent
<script src="{{ asset("js/admin/codemirror.js") }}"></script>
    <script src="{{ asset("js/admin/closetag.js") }}"></script>
    <script src="{{ asset("js/admin/htmlmixed.js") }}"></script>
    <script src="{{ asset("js/admin/css.js") }}"></script>
    <script src="{{ asset("js/admin/javascript.js") }}"></script>
    <script src="{{ asset("js/admin/xml.js") }}"></script>
    <script src="{{ asset("js/admin/xml-fold.js") }}"></script>
    <script>
      var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
        mode: 'text/html',
        autoCloseTags: true
      });
    </script>
@endsection
