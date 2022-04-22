<div>
    <div class="container max-width-adaptive-md padding-top-md">

      <div class="text-component title text-center">
        <h1>Подбор фитнес-браслета</h1>
      </div>

    <div class="steps text-sm@md margin-y-lg" aria-label="Multi-step indicator">
  <ol class="steps__list">

    <li class="step @if ($step == 1) step--current @else step--completed @endif">
      <a class="step__label" href="#0" wire:click.prevent="goStep(1)">Совместимость</a>

      <span class="step__separator" aria-hidden="true">
        <svg class="icon" viewBox="0 0 16 16"><polyline fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" points="6.5,3.5 11,8 6.5,12.5 "></polyline></svg>
      </span>
      @if ($step != 1)
        <div class="step__circle" aria-hidden="true">
          <svg class="icon" viewBox="0 0 16 16"><polyline fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points="1,9 5,13 15,3 "></polyline></svg>
        </div>
        @else

        <div class="step__circle" aria-hidden="true">1</div>
      @endif
    </li>


    <li class="step @if ($step == 2) step--current @elseif ($step > 2) step--completed @endif">
      <a class="step__label" href="#0" wire:click.prevent="goStep(2)">Бюджет</a>

      <span class="step__separator" aria-hidden="true">
        <svg class="icon" viewBox="0 0 16 16"><polyline fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" points="6.5,3.5 11,8 6.5,12.5 "></polyline></svg>
      </span>

      @if ($step > 2)
        <div class="step__circle" aria-hidden="true">
          <svg class="icon" viewBox="0 0 16 16"><polyline fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points="1,9 5,13 15,3 "></polyline></svg>
        </div>
        @else

      <div class="step__circle" aria-hidden="true">2</div>
      @endif

    </li>

    <li class="step @if ($step == 3) step--current @elseif ($step > 3) step--completed @endif">
      <a class="step__label" href="#0" wire:click.prevent="goStep(3)">Предназначение</a>

      <span class="step__separator" aria-hidden="true">
        <svg class="icon" viewBox="0 0 16 16"><polyline fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" points="6.5,3.5 11,8 6.5,12.5 "></polyline></svg>
      </span>

      @if ($step > 3)
        <div class="step__circle" aria-hidden="true">
          <svg class="icon" viewBox="0 0 16 16"><polyline fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points="1,9 5,13 15,3 "></polyline></svg>
        </div>
        @else

      <div class="step__circle" aria-hidden="true">3</div>
      @endif

    </li>

    <li class="step @if ($step == 4) step--current @elseif ($step > 4) step--completed @endif">
      <a class="step__label" href="#0" wire:click.prevent="goStep(4)">Доп. функции</a>

      <span class="step__separator" aria-hidden="true">
        <svg class="icon" viewBox="0 0 16 16"><polyline fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" points="6.5,3.5 11,8 6.5,12.5 "></polyline></svg>
      </span>

      @if ($step > 4)
      <div class="step__circle" aria-hidden="true">
        <svg class="icon" viewBox="0 0 16 16"><polyline fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points="1,9 5,13 15,3 "></polyline></svg>
      </div>
      @else
        <div class="step__circle" aria-hidden="true">4</div>
      @endif

    </li>

    <li class="step @if ($step == 5) step--current @elseif ($step > 5) step--completed @endif">
      <a class="step__label" href="#0" wire:click.prevent="goStep(5)">Дисплей</a>

      <span class="step__separator" aria-hidden="true">
        <svg class="icon" viewBox="0 0 16 16"><polyline fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" points="6.5,3.5 11,8 6.5,12.5 "></polyline></svg>
      </span>

      @if ($step > 5)
      <div class="step__circle" aria-hidden="true">
        <svg class="icon" viewBox="0 0 16 16"><polyline fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points="1,9 5,13 15,3 "></polyline></svg>
      </div>
      @else
        <div class="step__circle" aria-hidden="true">5</div>
      @endif

    </li>

    <li class="step @if ($step == 6) step--current @elseif ($step > 6) step--completed @endif">
      <a class="step__label">Защита</a>

      <div class="step__circle" aria-hidden="true">6</div>
      @if ($step > 6)
      <div class="step__circle" aria-hidden="true">
        <svg class="icon" viewBox="0 0 16 16"><polyline fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points="1,9 5,13 15,3 "></polyline></svg>
      </div>
      @else
        <div class="step__circle" aria-hidden="true">6</div>
      @endif
    </li>
  </ol>
</div>

@if ($step == 1)
            <form>
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

                <div class="border-top border-contrast-higher border-opacity-10% padding-y-md">
                  <div class="grid">
                    <div class="col-6">

                    </div>
                    <div class="col-6">
                    <button wire:click.prevent="nextStep" class="btn btn--sm btn--primary width-100% width-auto@md">Следующий шаг &rarr;</button>
                    </div>
                  </div>
              </div>
            </form>

          <aside class="note">
            <div class="flex items-center">
              <svg class="icon icon--md margin-right-sm" viewBox="0 0 30 30">
                <circle cx="15" cy="15" r="14" fill="var(--color-primary)" opacity=".2"></circle>
                <path fill="none" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13v9"></path>
                <circle cx="15" cy="8.5" r="1.5" fill="var(--color-primary)"></circle>
              </svg>

              <p class="note__title color-contrast-higher"><strong>Справка</strong></p>
            </div>

            <div class="flex margin-top-xxxs">
              <!-- spacer - occupy same space of icon above 👆 -->
              <svg class="icon icon--md margin-right-sm" aria-hidden="true"></svg>

              <div class="note__content text-component">
                <!-- note content -->
                <p>Все современные фитнес-браслеты поддерживают сопряжение как с телефонами на Android, так и на IOS. Но могут возникнуть трудности, если ваш смартфон работает на Windows Phone, а также если подходящий вам браслет был разработан под определенную систему. Поэтому лучше сразу обозначить тип ОС.</p>
                <!-- end note content -->
              </div>
            </div>
          </aside>

        @endif

        @if ($step == 2)

            <form>
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

    <div class="border-top border-contrast-higher border-opacity-10% padding-y-md">
        <div class="grid">
          <div class="col-6">
              <a class="btn btn--sm btn--subtle flex-grow flex-grow-0@md js-wiz-form__prev" wire:click.prevent="previousStep">&larr; Предыдущий шаг</a>
          </div>

          <div class="col-6">
              <a class="btn btn--sm btn--primary flex-grow flex-grow-0@md" wire:click.prevent="nextStep">Следующий шаг &rarr;</a>
          </div>
        </div>
    </div>
  </form>



<aside class="note">
  <div class="flex items-center">
    <svg class="icon icon--md margin-right-sm" viewBox="0 0 30 30">
      <circle cx="15" cy="15" r="14" fill="var(--color-primary)" opacity=".2"></circle>
      <path fill="none" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13v9"></path>
      <circle cx="15" cy="8.5" r="1.5" fill="var(--color-primary)"></circle>
    </svg>

    <p class="note__title color-contrast-higher"><strong>Справка:</strong></p>
  </div>

  <div class="flex margin-top-xxxs">
    <!-- spacer - occupy same space of icon above 👆 -->
    <svg class="icon icon--md margin-right-sm" aria-hidden="true"></svg>

    <div class="note__content text-component">
    <p>Фитнес браслет довольно недорой гаджет, поэтому за 3-4 тысячи рублей можно приобрести идеальное устройство. Но есть среди трекеров и премиальные модели, которые помимо основного функционала и именитого производителя, могут предложить уникальные возможности и технические нововведения. Такие девайсы будут стоить намного дороже. По стоимости трекеров рынок можно разбить на 3 сегмента:</p>
    <ul class="list list--ul">
    <li><span class="text-bold">Низкий бюджет (до 3 000 рублей)</span>. Территория низкого бюджета закреплена за китайскими устройствами. На главных ролях тут Xiaomi и Honor, которые постоянно конкурируют между собой. Также большое количество низкобюджетных фитнес браслетов покупается в интернет-магазине Алиэкспресс, который зачастую предлагает очень достойные устройства. Но периодически этот сегмент пытаются покорить такие бренды, как Samsung, Sony, Qumann и IWOWN;</li>
    <li><span class="text-bold">Средний бюджет (до 6 000 рублей</span>. За такие деньги вы можете рассчитывать на современный браслет сочетающий в себе как основной функционал, так и дополнительные «фишки», доступные только на определенном трекере. Многие модели Huawei и Honor представлены именно в среднем бюджете (если их покупать в России, а не заказывать из Китая). Кроме того, за 3-6 тысяч рублей вы можете позволить себе любое устройство от Amazfit или Bizzaro, а также начальные фитнес-браслеты от Samsung и Garmin;</li>
    <li><span class="text-bold">Высокий бюджет (до 10 000 рублей)</span>. В данном сегменте можно встретить как действительно достойные фитнес браслеты от проверенных брендов (Samsung, Garmin, Fitbit, Yamaguchi), так и посредников, продающих OEM-продукцию под своим брендом по завышенной цене;</li>
    <li><span class="text-bold">Премиальный бюджет (от 10 000 рублей)</span> – здесь представлены либо премиальные фитнес-браслеты от известных американских, корейских и финских производителей, которые по функционалу скорее напоминают умные часы, либо трекеры, выполненные из дорогих материалов.</li>
    </ul>
    </div>
  </div>
</aside>

@endif

@if ($step == 3)

<form>
    <fieldset class="margin-bottom-md">
      <legend class="form-legend font-bold margin-bottom-xxs">Предназначение:</legend>
          <ul>
            @foreach ($dest[0] as $key => $value)
              <li class="margin-bottom-sm">
                  <input class="checkbox" type="checkbox" wire:model="selectedDestination" name="selectedDestination[]" id="destination-{{ $loop->index }}" value="{{ $value }}">
                  <label for="destination-{{ $loop->index }}">{{ $key }}</label>
              </li>
            @endforeach
          </ul>
    </fieldset>

    <div class="border-top border-contrast-higher border-opacity-10% padding-y-md">
        <div class="grid">
          <div class="col-6">
              <a class="btn btn--sm btn--subtle flex-grow flex-grow-0@md js-wiz-form__prev" wire:click.prevent="previousStep">&larr; Предыдущий шаг</a>
          </div>

          <div class="col-6">
              <a class="btn btn--sm btn--primary flex-grow flex-grow-0@md" wire:click.prevent="nextStep">Следующий шаг &rarr;</a>
          </div>
        </div>
    </div>
  </form>

  <aside class="note">
    <div class="flex items-center">
      <svg class="icon icon--md margin-right-sm" viewBox="0 0 30 30">
        <circle cx="15" cy="15" r="14" fill="var(--color-primary)" opacity=".2"></circle>
        <path fill="none" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13v9"></path>
        <circle cx="15" cy="8.5" r="1.5" fill="var(--color-primary)"></circle>
      </svg>

      <p class="note__title color-contrast-higher"><strong>Справка</strong></p>
    </div>

    <div class="flex margin-top-xxxs">
      <!-- spacer - occupy same space of icon above 👆 -->
      <svg class="icon icon--md margin-right-sm" aria-hidden="true"></svg>

      <div class="note__content text-component">
        <p>Практически все фитнес браслеты являются многофункциональными устройствами, которые могут применятся сразу в нескольких сферах жизни. Но есть трекеры, у которых та или иная функция проработана более качественно и подробно, а некоторые браслеты вообще разрабатываются под определенные потребности. Основные предназначения фитнес браслетов:</p>
        <ul class="list list--ul">
          <li><span class="text-bold">Связь со смартфоном.</span> Большинство покупателей фитнес-трекеров просто нуждаются в умном гаджете, который украшал бы их запястье и мог принимать уведомления со смартфона, а также выводил текст сообщений;</li>
          <li><span class="text-bold">Бег.</span> Некоторые используют фитнес браслет исключительно для бега, поэтому хотят иметь полную статистику о данном виде активности. Кроме того, такой браслет должен обладать хорошей точностью в подсчете шагов и пройденного расстояния;</li>
          <li><span class="text-bold">Тренажерный зал.</span> При занятиях в тренажерном зале очень важно контролировать пульс, поэтому ключевым параметром для трекера будет являться наличие функции постоянного измерения пульса. Кроме того, такой фитнес браслет должен обладать режимом «Свободная тренировка», «Бег на беговой дорожке», «Велотренажер» и т.д., а также иметь таймер и секундомер;</li>
          <li><span class="text-bold">Плавание.</span> Для пловцов обязательным является наличие должной водонепроницаемости у фитнес-браслета. Поэтому в данном пункте собраны только те устройства, которые имеют класс водонепроницаемости не ниже WR50, либо пылевлагозащиту не ниже IP68. Но ключевым параметром для таких фитнес браслетов является наличие режима «Плавание», в котором браслет составляет подробную статистику о ваших заплывах;</li>
          <li><span class="text-bold">Мониторинг сна.</span> Данный пункт нацелен на пользователей, которые нуждаются в постоянном и подробном отслеживании сна. Также большинство браслетов представленных здесь дают рекомендации по улучшению сна и выявляют основные проблемы. Умный будильник - это еще один обязательный параметр для улучшения качества сна;</li>
          <li><span class="text-bold">Отслеживания медицинских показателей.</span> Фитнес браслеты данной категории можно порекомендовать людям, которые имеют проблемы со здоровьем и нуждаются в постоянном отслеживании таких медицинских показателей, как артериальное давление, уровень кислорода в крови, пульс в состоянии покоя. Также данные трекеры имеют специальные календари с функцией напоминание о приеме лекарств, воды, о необходимости подвигаться;</li>
          <li><span class="text-bold">Универсальный.</span> Если же вы хотите, чтобы ваш умный браслет умел отслеживать все виды активности и обладал всеми мультимедийными возможностями, то выберайте данный пункт;</li>
          <li><span class="text-bold">Другие виды активности.</span> Если среди представленных сфер применения фитнес браслетов вы не нашли для себя подходящей, то скорее всего вы нуждаетесь в отслеживании какого-то локального вида активности, например, катание на велосипеде, тренировка на эллипсоиде или занятие на тренажере для гребли. Здесь мы собрали все фитнес браслеты с нестандартными функциями и возможностями.</li>
        </ul>
      </div>
    </div>
  </aside>

@endif


@if ($step == 4)

<form>
    <fieldset class="margin-bottom-md">
      <legend class="form-legend font-bold margin-bottom-xxs">Выберите дополнительные функции фитнес-браслета</legend>
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
    </fieldset>

<div class="border-top border-contrast-higher border-opacity-10% padding-y-md">
  <div class="grid">
    <div class="col-6">
        <a class="btn btn--sm btn--subtle flex-grow flex-grow-0@md js-wiz-form__prev" wire:click.prevent="previousStep">&larr; Предыдущий шаг</a>
    </div>

    <div class="col-6">
        <a class="btn btn--sm btn--primary flex-grow flex-grow-0@md" wire:click.prevent="nextStep">Следующий шаг &rarr;</a>
    </div>
  </div>
</div>

  </form>

  <aside class="note">
    <div class="flex items-center">
      <svg class="icon icon--md margin-right-sm" viewBox="0 0 30 30">
        <circle cx="15" cy="15" r="14" fill="var(--color-primary)" opacity=".2"></circle>
        <path fill="none" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13v9"></path>
        <circle cx="15" cy="8.5" r="1.5" fill="var(--color-primary)"></circle>
      </svg>

      <p class="note__title color-contrast-higher"><strong>Справка</strong></p>
    </div>

    <div class="flex margin-top-xxxs">
      <!-- spacer - occupy same space of icon above 👆 -->
      <svg class="icon icon--md margin-right-sm" aria-hidden="true"></svg>

      <div class="note__content text-component">
        <p>Определенный набор функций вы можете встретить в каждом современном фитнес браслете. К таким функциям относятся: мониторинг физической активности и сна, контроль сожженных калорий, подсчет шагов, прием уведомлений о воходящем вызове и СМС с телефона. Другие возможности могут меняться в зависимости от фитнес-браслета. К наиболее популярным дополнительным функциям можно отнести:</p>
        <ul class="list list--ul">
          <li><span class="text-bold">Постоянное измерение пульса.</span> Данная возможность позволяет отслеживать показания пульса в реальном времени. Например, вы можете отслеживать свой пульс на протяжении всей тренировки. Как правило, после тренировки в приложении фитнес-браслета строится график и выводится полная статистика по изменению пульса во время занятия;</li>
          <li><span class="text-bold">Напоминание о малоподвижности.</span> Суть данной функции заключается в периодическом оповещении пользователя о необходимости подвигаться в случае, если он долго находится в статичном положении, например, за компьютером или лежа на диване;</li>
          <li><span class="text-bold">Определение уровня кислорода в крови.</span> Данная функция позволяет с помощью фотоплетизмографического датчика измерить уровень насыщения артериальной крови кислородом (сатурация). В норме сатурация составляет 95%-100%. Если уровень падает ниже 94%, то у человека начинается гипоксия. При сатурации ниже 90% состояние относят к категории критических, которые требует безотлагательных мер;</li>
          <li><span class="text-bold">Гироскоп.</span> Это датчик, который реагирует на изменение ориентации девайса в пространстве. Не стоит путать его с акселерометром, который измеряет ускорение девайса в пространстве. Именно сочетание акселерометра и гироскопа позволяет отслеживать гребки в бассейне, отличать обычную жестикуляцию от шагов, автоматически определять вид активности и т.д. Довольно часто сочетание акселерометр+гироскоп называют 6-осевым акселерометром;</li>
          <li><span class="text-bold">Управление музыкой.</span> Данная функция позволяет управлять музыкальным плеером вашего смартфона через фитнес-браслет. Как правило, вам доступны следующие возможности: переключение треков, изменение громкости, пауза/пуск;</li>
          <li><span class="text-bold">Умный будильник.</span> Такой будильник не просто будит вас в указанное время, а определяет наиболее подходящий момент для пробуждения. Самой благоприятной для пробуждения является фаза быстрого сна (REM фаза), когда состояние организма человека схоже с состоянием в период бодрствования. Проснувшись во время REM фазы, вы не будете испытывать усталость и желание вернуться в кровать;</li>
          <li><span class="text-bold">Функция поиска смартфона.</span> Запустив на фитнес браслете данную опцию, ваш телефон начнет вибрировать и издавать сигнал, что поможет вам найти его;</li>
          <li><span class="text-bold">Управление камерой смартфона.</span> С помощью данной функции вы можете удаленно делать снимки на смартфон через фитнес браслет;</li>
          <li><span class="text-bold">Таймер/секундомер.</span> Для некоторых пользователей очень важное значение имеет наличие секундомера в фитнес браслете, особенно этот вопрос актуален для спортсменов;</li>
          <li><span class="text-bold">Высотомер.</span> Высотомер (альтиметр) работает благодаря датчикам атмосферно давления. Такая функция может быть полезна для людей, практикующих восхождения в горы, так как на экране фитнес браслета будет постоянно выводиться высота над уровнем моря.</li>
        </ul>
      </div>
    </div>
  </aside>

@endif


@if ($step == 5)

<form>
  <div class="grid gap-xs">
    <div class="col-4@md">
    <fieldset class="margin-bottom-md">
      <legend class="form-legend font-bold margin-bottom-xxs">Размер дисплея</legend>

      <ul class="flex flex-column gap-xxxs">
      <li>
        <input class="radio radio--bg" type="radio" name="radio-disp-size" id="radio-disp-size-little" wire:model="dispSize" value="little">
        <label for="radio-disp-size-little">Маленький</label>
      </li>

      <li>
        <input class="radio radio--bg" type="radio" wire:model="dispSize" name="radio-disp-size" id="radio-disp-size-medium" value="medium">
        <label for="radio-disp-size-medium">Средний</label>
      </li>

      <li>
        <input class="radio radio--bg" wire:model="dispSize" type="radio" name="radio-disp-size" id="radio-disp-size-big" value="big">
        <label for="radio-disp-size-big">Большой</label>
      </li>
    </ul>
    </fieldset>
    </div>

    <div class="col-4@md">
    <fieldset class="margin-bottom-md">
      <legend class="form-legend font-bold margin-bottom-xxs">Тип дисплея</legend>

      <ul class="flex flex-column gap-xxxs">
      <li>
        <input class="radio radio--bg" type="radio" name="radio-disp-color" id="radio-disp-color-true" wire:model="dispColor" value="color">
        <label for="radio-disp-color-true">Цветной</label>
      </li>

      <li>
        <input class="radio radio--bg" type="radio" wire:model="dispColor" name="radio-disp-color" id="radio-disp-color-false" value="mono">
        <label for="radio-disp-color-false">Монохромный</label>
      </li>
    </ul>
    </fieldset>
    </div>


    <div class="col-4@md">
    <fieldset class="margin-bottom-md">
      <legend class="form-legend font-bold margin-bottom-xxs">Качество дисплея</legend>

      <ul class="flex flex-column gap-xxxs">
      <li>
        <input class="radio radio--bg" type="radio" name="radio-button" id="radio-disp-dpi-low" wire:model="dispDpi" value="low">
        <label for="radio-disp-dpi-low">Низкое</label>
      </li>

      <li>
        <input class="radio radio--bg" type="radio" wire:model="dispDpi" name="radio-button" id="radio-disp-dpi-middle" value="middle">
        <label for="radio-disp-dpi-middle">Среднее</label>
      </li>

      <li>
        <input class="radio radio--bg" wire:model="dispDpi" type="radio" name="radio-button" id="radio-disp-dpi-high" value="high">
        <label for="radio-disp-dpi-high">Высокое</label>
      </li>
    </ul>
    </fieldset>
    </div>
  </div>

    <div class="border-top border-contrast-higher border-opacity-10% padding-y-md">
      <div class="grid">
        <div class="col-6">
            <a class="btn btn--sm btn--subtle flex-grow flex-grow-0@md js-wiz-form__prev" wire:click.prevent="previousStep">&larr; Предыдущий шаг</a>
        </div>

        <div class="col-6">
            <a class="btn btn--sm btn--primary flex-grow flex-grow-0@md" wire:click.prevent="nextStep">Следующий шаг &rarr;</a>
        </div>
      </div>
    </div>

  </form>


  <aside class="note">
    <div class="flex items-center">
      <svg class="icon icon--md margin-right-sm" viewBox="0 0 30 30">
        <circle cx="15" cy="15" r="14" fill="var(--color-primary)" opacity=".2"></circle>
        <path fill="none" stroke="var(--color-primary)" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13v9"></path>
        <circle cx="15" cy="8.5" r="1.5" fill="var(--color-primary)"></circle>
      </svg>

      <p class="note__title color-contrast-higher"><strong>Справка</strong></p>
    </div>

    <div class="flex margin-top-xxxs">
      <!-- spacer - occupy same space of icon above 👆 -->
      <svg class="icon icon--md margin-right-sm" aria-hidden="true"></svg>

      <div class="note__content text-component">
        <p>Сейчас практически все браслеты оснащаются хоть каким-нибудь экраном, поэтому вопрос заключается в том, какой экран нужен вам? Если вы ищете фитнес браслет исключительно для занятий спортом и отслеживания собственной активности, то смысла в цветном детализированном дисплее нет, вам подойдет любой монохромный OLED экран с PPI от 140 пикселей.</p>
        <p>Если же для вас имеет значение внешний вид фитнес трекера, а использоваться он будет не только для контроля активности, но и для повседневных мелочей (чтение сообщений, работа с уведомлениями с телефона) или вы просто любитель стильных и дорогих гаджетов, то рекомендуем взглянуть на браслеты с AMOLED или POLED матрицей и плотностью пикселей от 200.</p>
        <p>Что касается размера дисплея, то тут все зависит от предназначения фитнес-браслета:</p>
        <ul class="list list--ul">
          <li><span class="text-bold">Маленький дисплей (до 0,8 дюйма).</span> Экран для вывода односложной информации вроде количества шагов, калорий, пульса. Не поддерживает чтение текста уведомлений и не может отобразить подробную статистику;</li>
          <li><span class="text-bold">Средний дисплей (от 0,8 до 1 дюйма).</span> Самый распространенный на рынке размер. Большинство моделей поддерживают прием и просмотр текста уведомлений из любых приложений. На среднем экране отображается больше информации, а также доступно больше настроек. Стоит также отметить, что при среднем экране фитнес-браслеты удается сохранить свою компактность;</li>
          <li><span class="text-bold">Большой дисплей (от 1 до 1.5 дюйма).</span> Фитнес браслеты с дисплеем от 1 дюйма уже не могут похвастаться компактностью, они скорее напоминают умные часы. Зато такие трекеры выводят информацию в удобном виде с красивой графикой и в достаточном масштабе. Конечно, с таких браслетов намного удобнее читать текст уведомлений.</li>
        </ul>
      </div>
    </div>
  </aside>

@endif


@if ($step == 6)

<form>
  <div class="grid gap-xs">
    <div class="col-5@md">
    <fieldset class="margin-bottom-md">
      <legend class="form-legend font-bold margin-bottom-xxs">Защита от воды</legend>

      <ul class="flex flex-column gap-xxxs">
      <li>
        <input class="radio radio--bg" type="radio" name="radio-protect" id="radio-protect-high" wire:model="protect" value="high">
        <label for="radio-protect-high">Высокая</label>
        <p class="text-xs color-contrast-medium x-iq">Плавание, дождь, пыль</p>
      </li>

      <li>
        <input class="radio radio--bg" type="radio" wire:model="protect" name="radio-protect" id="radio-protect-medium" value="medium">
        <label for="radio-protect-medium">Средняя</label>
        <p class="text-xs color-contrast-medium x-iq">Мытье рук, пыль</p>
      </li>

    </ul>

    </fieldset>

</div>

<div class="col-7@md">
    <div class="text-component">
      <p>Фитнес браслет довольно недорой гаджет, поэтому за 3-4 тысячи рублей можно приобрести идеальное устройство. Но есть среди трекеров и премиальные модели, которые помимо основного функционала и именитого производителя, могут предложить уникальные возможности и технические нововведения. Такие девайсы будут стоить намного дороже. По стоимости трекеров рынок можно разбить на 3 сегмента:</p>
    </div>
  </div>
  </div>
    <div class="border-top border-contrast-higher border-opacity-10% padding-top-md">
      <div class="container">
      <div class="grid gap-sm items-center">
        <div class="flex col col-6@md">
          <a class="btn btn--subtle flex-grow flex-grow-0@md js-wiz-form__prev" wire:click.prevent="previousStep">&larr; Предыдущий шаг</a>
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
