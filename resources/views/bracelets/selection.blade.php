
@extends('layouts.base')
{{-- Переопределяем секцию content от базового шаблона --}}
@section('content')

<form class="wiz-form bg height-100vh js-wiz-form">
  <div class="wiz-form__body">
    <!-- step 1 -->
    <fieldset class="wiz-form__step js-wiz-form__step">
      <div class="container max-width-xs">
        <header class="padding-top-md">
          <p class="text-sm color-contrast-medium line-height-xs">Step 1 <span class="hide@md">of 3</span></p>
          <h1 class="text-xl">Выбрать параметр</h1>
        </header>

        <div class="padding-y-md">
          <ul class="flex flex-column gap-xxxs">
            <li>
                <input class="checkbox" type="checkbox" name="heart_rate"
                    id="heart_rate" value="1" {{ request()->heart_rate == 1 ?
                'checked' : false }}>
                <label for="heart_rate">Постоянное измерение пульса</label>
            </li>
            <li>
                <input class="checkbox" type="checkbox" name="blood_oxy"
                    id="blood_oxy" value="1" {{ request()->blood_oxy == 1 ?
                'checked' : false }}>
                <label for="blood_oxy">Измерение уровня кислорода</label>
            </li>
          </ul>
        </div>
      </div>
    </fieldset>

    <!-- step 2 -->
    <fieldset class="wiz-form__step wiz-form__step--next js-wiz-form__step">
      <div class="container max-width-xs">
        <header class="padding-top-md">
          <p class="text-sm color-contrast-medium line-height-xs">Step 1 <span class="hide@md">of 3</span></p>
          <h1 class="text-xl">Выбрать параметр</h1>
        </header>

        <div class="padding-y-md">
          <ul class="flex flex-column gap-xxxs">
            <li>
                <input class="checkbox" type="checkbox" name="blood_pressure"
                    id="blood_pressure" value="1" {{ request()->blood_pressure == 1 ? 'checked'
                : false }}>
                <label for="blood_pressure">Измерение АД</label>
            </li>
            <li>
                <input class="checkbox" type="checkbox" name="nfc"
                    id="nfc" value="1" {{ request()->nfc == 1 ? 'checked'
                : false }}>
                <label for="nfc">NFC</label>
            </li>
          </ul>
        </div>
      </div>
    </fieldset>

    <!-- step 3 -->
    <fieldset class="wiz-form__step wiz-form__step--next js-wiz-form__step">
      <div class="container max-width-xs">
        <header class="padding-top-md">
          <p class="text-sm color-contrast-medium line-height-xs">Step 1 <span class="hide@md">of 3</span></p>
          <h1 class="text-xl">Выбрать параметр</h1>
        </header>

        <div class="padding-y-md">
          <label class="form-label margin-bottom-xxxs text-bold" for="disp_tech">Технология
                              дисплея:</label>

            <div class="select">
                <select class="select__input form-control" name="disp_tech" id="disp_tech">
                    <option value="">Выберите тип</option>
                    <option value="AMOLED" {{ request()->disp_tech == 'AMOLED' ? 'selected' : ''
                        }}>AMOLED</option>
                    <option value="IPS" {{ request()->disp_tech == 'IPS' ? 'selected' : '' }}>IPS
                    </option>
                    <option value="TFT" {{ request()->disp_tech == 'TFT' ? 'selected' : '' }}>TFT
                    </option>
                    <option value="LED" {{ request()->disp_tech == 'LED' ? 'selected' : '' }}>LED
                    </option>
                    <option value="OLED" {{ request()->disp_tech == 'OLED' ? 'selected' : '' }}>OLED
                    </option>
                    <option value="TN" {{ request()->disp_tech == 'TN' ? 'selected' : '' }}>TN
                    </option>
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
      </div>
    </fieldset>
  </div>

  <!-- footer -->
  <footer class="wiz-form__footer bg padding-y-sm shadow-md">
    <div class="container">
      <div class="grid gap-sm items-center">
        <div class="flex col col-3@md">
          <a class="btn btn--subtle flex-grow flex-grow-0@md js-wiz-form__prev" href="#0">&larr; Back</a>
        </div>

        <div class="display@md col-6@md">

          <div class="steps-v2 max-width-xs margin-x-auto js-wiz-form__step-indicator" style="--step-v2-current-step: 1;">
            <p class="text-sm color-contrast-medium margin-bottom-xs">Step <span class="js-steps-v2__current-step">1</span> of <span class="js-steps-v2__tot-steps">3</span></p>

            <div class="steps-v2__indicator" aria-hidden="true"></div>
          </div>
        </div>

        <div class="flex justify-end@md col col-3@md">
          <!-- "next" button -->
          <a class="btn btn--primary flex-grow flex-grow-0@md js-wiz-form__next" href="#0">Next &rarr;</a>

          <!-- "submit" button -->
          <button class="btn btn--primary flex-grow flex-grow-0@md js-wiz-form__submit">
            <svg class="icon icon--xs margin-right-xxs" viewBox="0 0 12 12">
              <title>check</title>
              <polyline points="0.5 7.5 3.5 10.5 11.5 1.5" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"></polyline>
            </svg>
            <span>Submit</span>
          </button>
        </div>
      </div>
    </div>
  </footer>
</form>
@endsection
@section('footerScripts')
   @parent
   <script>
     var wizardForm = document.getElementsByClassName('js-wiz-form')[0];
     var wizardFormObj = new WizardForm(wizardForm);
   </script> 
@endsection
