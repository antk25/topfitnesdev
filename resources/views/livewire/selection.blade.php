<div>
    <div class="container max-width-adaptive-md padding-top-md">

      <div class="text-component title text-center">
        <h1>Подбор фитнес-браслета</h1>
      </div>

    <div class="steps text-sm@md margin-y-lg" aria-label="Multi-step indicator">
  <ol class="steps__list">

    <li class="step @if ($step == 1) step--current @else step--completed @endif">
      <a class="step__label" href="#0">Совместимость</a>

      <span class="step__separator" aria-hidden="true">
        <svg class="icon" viewBox="0 0 16 16"><polyline fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" points="6.5,3.5 11,8 6.5,12.5 "></polyline></svg>
      </span>

      <div class="step__circle" aria-hidden="true">
        <svg class="icon" viewBox="0 0 16 16"><polyline fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points="1,9 5,13 15,3 "></polyline></svg>
      </div>
    </li>


    <li class="step @if ($step == 2) step--current @elseif ($step > 2) step--completed @endif">
      <a class="step__label">Бюджет</a>

      <span class="step__separator" aria-hidden="true">
        <svg class="icon" viewBox="0 0 16 16"><polyline fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" points="6.5,3.5 11,8 6.5,12.5 "></polyline></svg>
      </span>

      <div class="step__circle" aria-hidden="true">2</div>
    </li>

    <li class="step @if ($step == 3) step--current @elseif ($step > 3) step--completed @endif">
      <a class="step__label">Предназначение</a>

      <span class="step__separator" aria-hidden="true">
        <svg class="icon" viewBox="0 0 16 16"><polyline fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" points="6.5,3.5 11,8 6.5,12.5 "></polyline></svg>
      </span>

      <div class="step__circle" aria-hidden="true">3</div>
    </li>

    <li class="step @if ($step == 4) step--current @elseif ($step > 4) step--completed @endif">
      <a class="step__label">Review</a>

      <div class="step__circle" aria-hidden="true">4</div>
    </li>
  </ol>
</div>

@if ($step == 1)

            <form>
                <div class="grid gap-xs">
                    <div class="col-5@md">
                        <fieldset class="margin-bottom-md">
                            <legend class="form-legend font-bold margin-bottom-xxs">Выберите операционную систему вашего смартфона:</legend>


                            <ul class="flex flex-column gap-xxxs">
                                <li>
                                    <input class="radio radio--bg" type="radio" name="radio-11" id="radio-11" wire:model="compatibility" value="Android">
                                    <label for="radio-11">Android</label>
                                </li>

                                <li>
                                    <input class="radio radio--bg" type="radio" wire:model="compatibility" name="radio-12" id="radio-12" value="iOS">
                                    <label for="radio-12">iOS</label>
                                </li>
                            </ul>
                        </fieldset>
                    </div>

                    <div class="col-7@md">
                        <legend class="form-legend font-bold margin-bottom-xxs">Как выбирать:</legend>
                        <div class="text-component text-sm">
                            <p>Фитнес браслет довольно недорой гаджет, поэтому за 3-4 тысячи рублей можно приобрести идеальное устройство. Но есть среди трекеров и премиальные модели, которые помимо основного функционала и именитого производителя, могут предложить уникальные возможности и технические нововведения. Такие девайсы будут стоить намного дороже. По стоимости трекеров рынок можно разбить на 3 сегмента:</p>
                            <ul class="list list--ul">
                                <li><span class="text-bold">Низкий бюджет (до 3 000 рублей)</span>. Территория низкого бюджета закреплена за китайскими устройствами. На главных ролях тут Xiaomi и Honor, которые постоянно конкурируют между собой. Также большое количество низкобюджетных фитнес браслетов покупается в интернет-магазине Алиэкспресс, который зачастую предлагает очень достойные устройства. Но периодически этот сегмент пытаются покорить такие бренды, как Samsung, Sony, Qumann и IWOWN;</li>
                                <li><span class="text-bold">Средний бюджет (до 6 000 рублей</span>. За такие деньги вы можете рассчитывать на современный браслет сочетающий в себе как основной функционал, так и дополнительные «фишки», доступные только на определенном трекере. Многие модели Huawei и Honor представлены именно в среднем бюджете (если их покупать в России, а не заказывать из Китая). Кроме того, за 3-6 тысяч рублей вы можете позволить себе любое устройство от Amazfit или Bizzaro, а также начальные фитнес-браслеты от Samsung и Garmin;</li>
                                <li><span class="text-bold">Высокий бюджет (до 10 000 рублей)</span>. В данном сегменте можно встретить как действительно достойные фитнес браслеты от проверенных брендов (Samsung, Garmin, Fitbit, Yamaguchi), так и посредников, продающих OEM-продукцию под своим брендом по завышенной цене;</li>
                                <li><span class="text-bold">Премиальный бюджет (от 10 000 рублей)</span> – здесь представлены либо премиальные фитнес-браслеты от известных американских, корейских и финских производителей, которые по функционалу скорее напоминают умные часы, либо трекеры, выполненные из дорогих материалов.</li>
                            </ul>

                        </div>
                    </div>
                </div>
                <div class="text-right border-top border-contrast-higher border-opacity-10% padding-top-md">
                    <button wire:click.prevent="nextStep" class="btn btn--primary width-100% width-auto@md">Следующий шаг &rarr;</button>

                </div>
            </form>
@endif

        @if ($step == 2)

            <form>
                <div class="grid gap-xs">
    <div class="col-5@md">
    <fieldset class="margin-bottom-md">
      <legend class="form-legend font-bold margin-bottom-xxs">Выберите бюджет для покупки фитнес-браслета:</legend>

      <ul class="flex flex-column gap-xxxs">
      <li>
        <input class="radio radio--bg" type="radio" name="radio-button" id="radio-1" wire:model="budget" value="low">
        <label for="radio-1">Низкий (до 3 000 рублей)</label>
      </li>

      <li>
        <input class="radio radio--bg" type="radio" wire:model="budget" name="radio-button" id="radio-2" value="middle">
        <label for="radio-2">Средний (до 6 000 рублей)</label>
      </li>

      <li>
        <input class="radio radio--bg" wire:model="budget" type="radio" name="radio-button" id="radio-3" value="high">
        <label for="radio-3">Высокий (до 10 000 рублей)</label>
      </li>

      <li>
        <input class="radio radio--bg" wire:model="budget" type="radio" name="radio-button" id="radio-4" value="premium">
        <label for="radio-4">Премиальный (от 10 000 рублей)</label>
      </li>
    </ul>
    </fieldset>
</div>

<div class="col-7@md">
      <legend class="form-legend font-bold margin-bottom-xxs">Как выбирать:</legend>
    <div class="text-component text-sm">
      <p>Фитнес браслет довольно недорой гаджет, поэтому за 3-4 тысячи рублей можно приобрести идеальное устройство. Но есть среди трекеров и премиальные модели, которые помимо основного функционала и именитого производителя, могут предложить уникальные возможности и технические нововведения. Такие девайсы будут стоить намного дороже. По стоимости трекеров рынок можно разбить на 3 сегмента:</p>
<ul class="list list--ul">
<li><span class="text-bold">Низкий бюджет (до 3 000 рублей)</span>. Территория низкого бюджета закреплена за китайскими устройствами. На главных ролях тут Xiaomi и Honor, которые постоянно конкурируют между собой. Также большое количество низкобюджетных фитнес браслетов покупается в интернет-магазине Алиэкспресс, который зачастую предлагает очень достойные устройства. Но периодически этот сегмент пытаются покорить такие бренды, как Samsung, Sony, Qumann и IWOWN;</li>
<li><span class="text-bold">Средний бюджет (до 6 000 рублей</span>. За такие деньги вы можете рассчитывать на современный браслет сочетающий в себе как основной функционал, так и дополнительные «фишки», доступные только на определенном трекере. Многие модели Huawei и Honor представлены именно в среднем бюджете (если их покупать в России, а не заказывать из Китая). Кроме того, за 3-6 тысяч рублей вы можете позволить себе любое устройство от Amazfit или Bizzaro, а также начальные фитнес-браслеты от Samsung и Garmin;</li>
<li><span class="text-bold">Высокий бюджет (до 10 000 рублей)</span>. В данном сегменте можно встретить как действительно достойные фитнес браслеты от проверенных брендов (Samsung, Garmin, Fitbit, Yamaguchi), так и посредников, продающих OEM-продукцию под своим брендом по завышенной цене;</li>
<li><span class="text-bold">Премиальный бюджет (от 10 000 рублей)</span> – здесь представлены либо премиальные фитнес-браслеты от известных американских, корейских и финских производителей, которые по функционалу скорее напоминают умные часы, либо трекеры, выполненные из дорогих материалов.</li>
</ul>

    </div>
  </div>
  </div>
    <div class="border-top border-contrast-higher border-opacity-10% padding-top-md">
        <div class="container">
            <div class="grid gap-sm items-center">
                <div class="flex col col-6@md">
                    <a class="btn btn--subtle flex-grow flex-grow-0@md js-wiz-form__prev" wire:click.prevent="previousStep">&larr; Предыдущий шаг</a>
                </div>


                <div class="flex justify-end@md col col-6@md">
                    <!-- "next" button -->
                    <a class="btn btn--primary flex-grow flex-grow-0@md" wire:click.prevent="nextStep">Следующий шаг &rarr;</a>
                </div>
            </div>
        </div>
    </div>
  </form>



@endif

@if ($step == 3)


<form>
  <div class="grid gap-xs">
    <div class="col-5@md">
    <fieldset class="margin-bottom-md">
      <legend class="form-legend font-bold margin-bottom-xxs">Предназначение</legend>

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

<div class="col-7@md">
    <div class="text-component">
      <p>Фитнес браслет довольно недорой гаджет, поэтому за 3-4 тысячи рублей можно приобрести идеальное устройство. Но есть среди трекеров и премиальные модели, которые помимо основного функционала и именитого производителя, могут предложить уникальные возможности и технические нововведения. Такие девайсы будут стоить намного дороже. По стоимости трекеров рынок можно разбить на 3 сегмента:</p>

Низкий бюджет (до 3 000 рублей). Территория низкого бюджета закреплена за китайскими устройствами. На главных ролях тут Xiaomi и Honor, которые постоянно конкурируют между собой. Также большое количество низкобюджетных фитнес браслетов покупается в интернет-магазине Алиэкспресс, который зачастую предлагает очень достойные устройства. Но периодически этот сегмент пытаются покорить такие бренды, как Samsung, Sony, Qumann и IWOWN;
Средний бюджет (до 6 000 рублей). За такие деньги вы можете рассчитывать на современный браслет сочетающий в себе как основной функционал, так и дополнительные «фишки», доступные только на определенном трекере. Многие модели Huawei и Honor представлены именно в среднем бюджете (если их покупать в России, а не заказывать из Китая). Кроме того, за 3-6 тысяч рублей вы можете позволить себе любое устройство от Amazfit или Bizzaro, а также начальные фитнес-браслеты от Samsung и Garmin;
Высокий бюджет (до 10 000 рублей). В данном сегменте можно встретить как действительно достойные фитнес браслеты от проверенных брендов (Samsung, Garmin, Fitbit, Yamaguchi), так и посредников, продающих OEM-продукцию под своим брендом по завышенной цене;
Премиальный бюджет (от 10 000 рублей) – здесь представлены либо премиальные фитнес-браслеты от известных американских, корейских и финских производителей, которые по функционалу скорее напоминают умные часы, либо трекеры, выполненные из дорогих материалов.
    </div>
  </div>
  </div>
    <div class="border-top border-contrast-higher border-opacity-10% padding-top-md">
      <div class="container">
      <div class="grid gap-sm items-center">
        <div class="flex col col-6@md">
          <a class="btn btn--subtle flex-grow flex-grow-0@md js-wiz-form__prev" wire:click.prevent="previousStep">&larr; Предыдущий шаг</a>
        </div>


        <div class="flex justify-end@md col col-6@md">
          <!-- "next" button -->
          <a class="btn btn--primary flex-grow flex-grow-0@md" wire:click.prevent="nextStep">Следующий шаг &rarr;</a>
        </div>
      </div>
    </div>
    </div>
  </form>


@endif


<div class="margin-y-sm">
    Всего результатов: {{ $bracelets->count() }}
</div>
<section class="margin-y-md">
                @foreach ($bracelets as $bracelet)

                @include('livewire.bracelets.selection', ['bracelet' => $bracelet])

                @endforeach
</section>
    </div>
</div>
