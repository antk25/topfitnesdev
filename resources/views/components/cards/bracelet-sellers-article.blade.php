{{-- Блок с партнерками и рекламой --}}
{{-- Если есть продавцы (причем первыми должны стоять алиэкспресс) и id на е-каталоге,
то выводим одного первого продавца и е-каталог, если нет е-каталога, то выводим всех продавцов. --}}
@if ($bracelet->sellers->count())
    <div class="text-divider"><span>Где купить в Москве и регионах</span></div>
    <section class="margin-y-sm">
        <div class="table-card radius-md padding-sm border-2 border">
            <div class="tbl text-sm">
                <table class="tbl__table" aria-label="Table Example">
                    <thead class="tbl__header sr-only">
                    <tr class="tbl__row">
                        <th class="tbl__cell text-left" scope="col">
                            <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Магазин</span>
                        </th>

                        <th class="tbl__cell text-left" scope="col">
                            <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Цена</span>
                        </th>

                        <th class="tbl__cell text-right" scope="col">
                            <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Купить</span>
                        </th>
                    </tr>
                    </thead>

                    <tbody class="tbl__body">
                    @foreach ($bracelet->sellers as $seller)
                        <tr class="tbl__row">
                            <td class="tbl__cell text-md text-bold" role="cell">
                                @if ($seller->marketplace)
                                    {{ $seller->marketplace }}
                                @else
                                    {{ $seller->name }}
                                @endif
                            </td>

                            <td class="tbl__cell" role="cell">
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
                            </td>

                            <td class="tbl__cell" role="cell">
                                <div class="flex justify-end">
                                    <a rel="nofollow" target="_blank"
                                       href="{{ $seller->pivot->link }}"
                                       class="btn btn--primary">Купить</a>
                                </div>
                            </td>
                        </tr>
                        {{-- Тут проверка, что есть id на е-каталоге и завершаем цикл, если есть --}}
                        @if ($bracelet->id_ecat)
                            @break
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endif
{{-- Тут выводим е-каталог. Соответственно, если есть только он, то он и выведется --}}
@if ($bracelet->id_ecat)
    <p class="text-md">Таблица из е-каталога</p>
@endif

{{-- В том случае, если нет продавцов и е-каталога, то выводим контекстную рекламу --}}

@if (!$bracelet->id_ecat & !$bracelet->sellers->count())
    <p>Реклама Adsense</p>
@endif

{{-- Конец блока с партнерками и рекламой --}}
