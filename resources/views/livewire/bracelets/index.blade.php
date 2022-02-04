{{-- <div class="prod-card-v2 col-3@sm col-6">
<span class="prod-card-v2__badge" role="text"><svg class="icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M22.765 9.397a.676.676 0 00-.538-.453l-6.64-1.015-2.976-6.34c-.222-.474-.999-.474-1.222 0L8.413 7.93l-6.64 1.015a.674.674 0 00-.381 1.139l4.824 4.945-1.14 6.99a.673.673 0 00.992.699L12 19.439l5.931 3.278a.672.672 0 00.993-.699l-1.14-6.99 4.824-4.945a.675.675 0 00.157-.686z" fill="#ffc107"/><path d="M5.574 15.362l-1.267 7.767a.751.751 0 001.103.777L12 20.264l6.59 3.643a.748.748 0 001.103-.778l-1.267-7.767 5.36-5.494a.75.75 0 00-.423-1.265l-7.378-1.127L12.678.432c-.247-.526-1.11-.526-1.357 0L8.015 7.476.637 8.603a.75.75 0 00-.424 1.265zm3.063-6.464a.75.75 0 00.565-.422L12 2.515l2.798 5.96a.747.747 0 00.565.422l6.331.967-4.605 4.72a.75.75 0 00-.204.645l1.08 6.617-5.602-3.096a.755.755 0 00-.726 0l-5.602 3.096 1.08-6.617a.75.75 0 00-.204-.645l-4.605-4.72z"/></svg>&nbsp;<span class="text-bold">{{ $bracelet->grade_bracelet }}</span> <i class="sr-only">product</i></span>

  <a href="katalog/{{ $bracelet->slug }}" class="prod-card-v2__img-link" aria-label="Подробнее о браслете {{ $bracelet->name }}">
    <figure>
      <img src="{{ $bracelet->getFirstMediaUrl('bracelet', 'thumb') }}">
    </figure>
  </a>

  <div class="padding-sm text-center border border-contrast-lower">
    <p class="text-sm"><a href="katalog/{{ $bracelet->slug }}" class="product-card-v2__title">{{ $bracelet->subtitle }}</a></p>
    <div class="text-sm text-left margin-top-sm">
        @if ($bracelet->avg_price != '')
    <span class="color-contrast-medium">Средняя цена:</span> {{ $bracelet->avg_price }}<br>
        @endif

        @if ($bracelet->nfc != '')
    <span  class="badge badge--primary-light text-sm margin-right-xs">NFC</span>
        @endif
        @if ($bracelet->oxy_permanent == 1)
    <span  class="badge badge--primary-light text-sm margin-right-xs">Пульсоксиметр</span>
        @endif

        @if ($bracelet->ad_permanent == 1)
    <span  class="badge badge--primary-light text-sm margin-right-xs">Измерение давления</span>
        @endif
    </div>


  </div>
</div> --}}

<div class="grid gap-sm">
  <div class="col-2@md border radius-md padding-xxxs">
  <img src="{{ $bracelet->getFirstMediaUrl('bracelets', 'thumb') }}">
</div>
<div class="col-5@md">
  <h3 class="text-md"><a href="{{ route('pub.bracelets.show', ["bracelet" => $bracelet]) }}">{{ $bracelet->name }}</a></h3>

  <div class="text-sm margin-top-sm text-left">
      <span class="color-contrast-medium">Поддержка NFC:</span> @if ($bracelet->nfc != '') Да @else Нет @endif<br>
      <span class="color-contrast-medium">Пульсоксиметр:</span> @if ($bracelet->oxy_permanent != '') Да @else Нет @endif<br>
      <span class="color-contrast-medium">Измерение давления:</span> @if ($bracelet->ad_permanent != '') Да @else Нет @endif<br>
      <div class="display@xs">
      <span class="color-contrast-medium">Совместимость:</span> @if ($bracelet->compatibility != null)
      @foreach ($bracelet->compatibility as $item)
         {{ $item }},
      @endforeach
      @endif<br>
      <span class="color-contrast-medium">Разрешение дисплея:</span> {{ $bracelet->disp_resolution }}<br>
      <span class="color-contrast-medium">Постоянное измерение пульса:</span> {{ $bracelet->heart_rate }}<br>
      </div>
    </div>
  </div>
<div class="col-5@md">
  @if ($bracelet->sellers->count())
  @foreach ($bracelet->sellers as $seller)
  <div class="flex">
    <div class="padding-sm">
  @if ($seller->marketplace)
      {{ $seller->marketplace }}
    @else
      {{ $seller->name }}
    @endif
  </div>
  <div class="padding-sm">
    @if ($seller->pivot->old_price != '')
    <del class="text-line-through text-bold color-contrast-medium margin-right-xxs">
        {{ $seller->pivot->old_price }}
    </del>
    <a class="link-fx-1 color-contrast-higher text-bold color-success"
       href="{{ $seller->pivot->link }}">
        <span>{{ $seller->pivot->price }}</span>
        <svg class="icon" viewBox="0 0 32 32"
             aria-hidden="true">
            <g fill="none" stroke="currentColor"
               stroke-linecap="round" stroke-linejoin="round">
                <circle cx="16" cy="16" r="15.5"/>
                <line x1="10" y1="18" x2="16" y2="12"/>
                <line x1="16" y1="12" x2="22" y2="18"/>
            </g>
        </svg>
    </a>
    @else
              <a class="link-fx-1 color-contrast-higher text-bold"
                 href="{{ $seller->pivot->link }}">
                  <span>{{ $seller->pivot->price }}</span>
                  <svg class="icon" viewBox="0 0 32 32"
                       aria-hidden="true">
                      <g fill="none" stroke="currentColor"
                         stroke-linecap="round" stroke-linejoin="round">
                          <circle cx="16" cy="16" r="15.5"/>
                          <line x1="10" y1="18" x2="16" y2="12"/>
                          <line x1="16" y1="12" x2="22" y2="18"/>
                      </g>
                  </svg>
              </a>
          @endif
        </div>
        </div>
@endforeach
  @endif

</div>
</div>


{{-- <div class="border radius-md padding-sm grid gap-md gap-lg@lg margin-bottom-sm shadow-sm">

  <div class="col-2">
  <a href="katalog/{{ $bracelet->slug }}"  aria-label="Подробнее о браслете {{ $bracelet->name }}">
      <img src="{{ $bracelet->getFirstMediaUrl('bracelet', 'thumb') }}">
  </a>
  </div>

  <div class="col-7">
      <p class="text-md"><a href="katalog/{{ $bracelet->slug }}">{{ $bracelet->subtitle }}</a></p>
      <div class="text-sm margin-top-sm">
          <span class="color-contrast-medium">Поддержка NFC:</span> @if ($bracelet->nfc != '') Да @else Нет @endif<br>
          <span class="color-contrast-medium">Пульсоксиметр:</span> @if ($bracelet->oxy_permanent != '') Да @else Нет @endif<br>
          <span class="color-contrast-medium">Измерение давления:</span> @if ($bracelet->ad_permanent != '') Да @else Нет @endif<br>
          <span class="color-contrast-medium">Совместимость:</span> @if ($bracelet->compatibility != null)
          @foreach ($bracelet->compatibility as $item)
             {{ $item }},
          @endforeach
          @endif<br>
          <span class="color-contrast-medium">Разрешение дисплея:</span> {{ $bracelet->disp_resolution }}<br>
          <span class="color-contrast-medium">Постоянное измерение пульса:</span> {{ $bracelet->heart_rate }}<br>
          <span class="color-contrast-medium">GPS:</span> {{ $bracelet->gps }}<br>
          <span class="color-contrast-medium">Защита:</span> @foreach ($bracelet->protect_stand as $item)
             {{ $item }},
          @endforeach<br>


      </div>
  </div>
  <div class="col-3">
      <div class="text-sm">
      @if ($bracelet->avg_price != '')
      <span class="color-contrast-medium">Средняя цена:</span> {{ $bracelet->avg_price }} руб<br>
          @endif
      </div>
  </div>
  </div> --}}