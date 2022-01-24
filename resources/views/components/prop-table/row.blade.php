@if (isset($spec))

<tr class="prop-table__row">
    <th class="prop-table__cell prop-table__cell--th">{{ $slot }}</th>

    @switch($type)
        @case('array')
         <td class="prop-table__cell">
            @foreach($spec as $item)
                @if (!$loop->last)
                    {{ $item }}@if(isset($unit)){!! $unit !!}@endif,
                @else
                    {{ $item }}@if(isset($unit)){!! $unit !!}@endif
                @endif
            @endforeach
         </td>
            @break
        @case('string')
        <td class="prop-table__cell">{{ $spec }}@if(isset($unit)){!! $unit !!}@endif</td>
        @break

        @case('bool')
        <td class="prop-table__cell">
            @if ($spec)
                <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option included</title>
                    <circle cx="12" cy="12" r="12" fill="#6ad354" opacity="0.2"/>
                    <polyline points="6 12 10 16 19 7" fill="none" stroke="#57d339"
                                stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"/>
                </svg>
            @else
                <svg class="icon icon--sm" viewBox="0 0 24 24"><title>Option not
                        included</title>
                    <circle cx="12" cy="12" r="12" fill="#e25656" opacity="0.2"/>
                    <g fill="none" stroke="#d13b3b" stroke-linecap="square"
                        stroke-miterlimit="10" stroke-width="2">
                        <line x1="7" y1="17" x2="17" y2="7"/>
                        <line x1="17" y1="17" x2="7" y2="7"/>
                    </g>
                </svg>
            @endif
        </td>
        @break

        @case('color')
            <td class="prop-table__cell">
                <div class="flex gap-xxs">
                @foreach($spec as $item)
                    @switch($item)
                        @case('белый')
                        <div class="square" title="белый" style="background-color: #ffffff;"></div>
                        @break
                        @case('черный')
                        <div class="square" title="черный" style="background-color: #000000;"></div>
                        @break
                        @case('зеленый')
                        <div class="square" title="зеленый" style="background-color: #008000;"></div>
                        @break
                        @case('коричневый')
                        <div class="square" title="коричневый" style="background-color: #A0522D;"></div>
                        @break
                        @case('синий')
                        <div class="square" title="синий" style="background-color: #00bfff;"></div>
                        @break
                        @case('желтый')
                        <div class="square" title="желтый" style="background-color: #ffff00;"></div>
                        @break
                        @case('красный')
                        <div class="square" title="красный" style="background-color: #ff0000;"></div>
                        @break
                        @case('оранжевый')
                        <div class="square" title="оранжевый" style="background-color: #ffa500;"></div>
                        @break
                        @case('розовый')
                        <div class="square" title="розовый" style="background-color: #ffc0cb;"></div>
                        @break
                        @case('серый')
                        <div class="square" title="серый" style="background-color: #808080;"></div>
                        @break
                        @case('фиолетовый')
                        <div class="square" title="фиолетовый" style="background-color: #8b00ff;"></div>
                        @break
                    @endswitch
                @endforeach
                </div>
            </td>
        @break

    @endswitch

</tr>


@endif