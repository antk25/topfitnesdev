<div class="grid gap-xs">
    <div class="col-3@sm">
        <a href="katalog/{{ $bracelet->slug }}" aria-label="Подробнее о браслете {{ $bracelet->name }}">
            <figure>
            <img src="{{ $bracelet->getFirstMediaUrl('bracelet', 'thumb') }}">
            </figure>
        </a>
        </div>
        <div class="col-9@sm">
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
    </div>
</div>