<div>
    @foreach ($bracelets as $bracelet)
        <div class="text-component__block--outset">

            <h2>{{ $bracelet->name }}</h2>
            <div class="grid gap-md items-center">
                <div class="col-4@sm">
                    <img loading="lazy" data-src="{{ $bracelet->getFirstMediaUrl('bracelet') }}"
                         src="/assets/theme/back-image/lazy-load-placeholder.svg"
                         class="block width-100% shadow-xs">
                    <noscript>
                        <img class="block width-100%" src="{{ $bracelet->getFirstMediaUrl('bracelet') }}">
                    </noscript>
                </div>

                <div class="col-8@sm">
                    <table class="prop-table width-100% margin-bottom-sm" aria-label="Property Table Example">
                        <tbody class="prop-table__body">
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Страна-производитель</th>
                            <td class="prop-table__cell">{{ $bracelet->country }}</td>
                        </tr>

                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Год выпуска</th>
                            <td class="prop-table__cell">{{ $bracelet->year }}</td>
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Время работы на одной зарядке
                            </th>
                            <td class="prop-table__cell">{{ $bracelet->real_time }}
                                {{ trans_choice('день|дня|дней', $bracelet->real_time) }}</td>
                        </tr>

                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Цветной дисплей</th>
                            <td class="prop-table__cell">@if ($bracelet->disp_color == 1) <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Опция доступна</title><circle cx="12" cy="12" r="12" fill="#6ad354" opacity="0.2"/><polyline points="6 12 10 16 19 7" fill="none" stroke="#57d339" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"/></svg> @else <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Опция недоступна</title><circle cx="12" cy="12" r="12" fill="#e25656" opacity="0.2"/><g fill="none" stroke="#d13b3b" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"><line x1="7" y1="17" x2="17" y2="7"/><line x1="17" y1="17" x2="7" y2="7"/></g></svg> @endif</td>
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Умный будильник</th>
                            <td class="prop-table__cell">@if ($bracelet->smart_alarm == 1) <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Опция доступна</title><circle cx="12" cy="12" r="12" fill="#6ad354" opacity="0.2"/><polyline points="6 12 10 16 19 7" fill="none" stroke="#57d339" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"/></svg> @else <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Опция недоступна</title><circle cx="12" cy="12" r="12" fill="#e25656" opacity="0.2"/><g fill="none" stroke="#d13b3b" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"><line x1="7" y1="17" x2="17" y2="7"/><line x1="17" y1="17" x2="7" y2="7"/></g></svg> @endif</td>
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Диагональ</th>
                            <td class="prop-table__cell">{{ $bracelet->disp_diag }}"</td>
                        </tr>
                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Разрешение экрана</th>
                            <td class="prop-table__cell">{{ $bracelet->disp_resolution }}</td>
                        </tr>

                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">Мониторинг</th>
                            <td class="prop-table__cell">
                                @foreach ($bracelet->monitoring as $monitoring)
                                    @if ($loop->last)
                                        {{ $monitoring }}
                                    @else
                                        {{ $monitoring }},
                                    @endif
                                @endforeach
                            </td>
                        </tr>

                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">NFC</th>
                            <td class="prop-table__cell">@if ($bracelet->nfc != '') <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Опция доступна</title><circle cx="12" cy="12" r="12" fill="#6ad354" opacity="0.2"/><polyline points="6 12 10 16 19 7" fill="none" stroke="#57d339" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"/></svg> @else <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Опция недоступна</title><circle cx="12" cy="12" r="12" fill="#e25656" opacity="0.2"/><g fill="none" stroke="#d13b3b" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"><line x1="7" y1="17" x2="17" y2="7"/><line x1="17" y1="17" x2="7" y2="7"/></g></svg> @endif</td>
                        </tr>

                        <tr class="prop-table__row">
                            <th class="prop-table__cell prop-table__cell--th">GPS</th>
                            <td class="prop-table__cell">@if ($bracelet->gps == 1) <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Опция доступна</title><circle cx="12" cy="12" r="12" fill="#6ad354" opacity="0.2"/><polyline points="6 12 10 16 19 7" fill="none" stroke="#57d339" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"/></svg> @else <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Опция недоступна</title><circle cx="12" cy="12" r="12" fill="#e25656" opacity="0.2"/><g fill="none" stroke="#d13b3b" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"><line x1="7" y1="17" x2="17" y2="7"/><line x1="17" y1="17" x2="7" y2="7"/></g></svg> @endif</td>
                        </tr>

                        </tbody>
                    </table>
                    <div class="text-right">
                    <a class="btn-fx-1" href="{{ route('pub.bracelets.show', ['slug' => $bracelet->slug]) }}">
                        <div class="btn-fx-1__inner padding-y-xs padding-x-sm">
                            <span>Подробнее</span>

                            <div class="btn-fx-1__icon-wrapper" aria-hidden="true">
                                <svg class="icon margin-left-xxs" viewBox="0 0 20 20"><polyline points="8 5 13 10 8 15" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>

                                <svg class="icon margin-left-xxs" viewBox="0 0 20 20"><polyline points="8 5 13 10 8 15" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                            </div>
                        </div>
                    </a>
                    </div>

                </div>
            </div>
        </div>

       <x-cards.bracelet-grades-article :bracelet="$bracelet"/>

       <x-cards.bracelet-sellers-article :bracelet="$bracelet"/>

       @if($bracelet->pivot->text_rating)
         {!! $bracelet->pivot->text_rating !!}
        @else
         {!! $bracelet->about !!}
       @endif

       <x-cards.bracelet-plusminus-article :bracelet="$bracelet"/>

    @endforeach
</div>
