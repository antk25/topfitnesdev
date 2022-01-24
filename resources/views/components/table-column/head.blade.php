<div>
    <div class="tbl margin-y-md">
        <table class="tbl__table border-bottom border-2" aria-label="Table Example">
            <thead class="tbl__header border-bottom border-2">
            <tr class="tbl__row">
                <th class="tbl__cell text-left" scope="col">
                    <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Модель</span>
                </th>

            @foreach($specs as $spec)
                    <th class="tbl__cell text-left" scope="col">
                        <span class="text-xs text-uppercase letter-spacing-lg font-semibold">{{ $spec['value'] }}</span>
                    </th>
            @endforeach
            </tr>
            </thead>

            <tbody class="tbl__body">
            @foreach ($bracelets as $item)
                <tr class="tbl__row">
                    <td class="tbl__cell" role="cell">
                        <div class="flex items-center">
                            <figure
                                class="width-lg height-lg radius-50% flex-shrink-0 overflow-hidden margin-right-xs">
                                <img class="block width-100% height-100% object-cover"
                                     src="{{ $item->getFirstMediaUrl('bracelets', '320') }}">
                            </figure>

                            <div class="line-height-xs">
                                <p class="margin-bottom-xxxxs text-bold">{{ $item->name }}</p>
                            </div>
                        </div>
                    </td>

                @foreach($specs as $spec)
                    @switch($spec['specs'])
                        @case('real_time')
                        <x-table-row.rows.days :item="$item->real_time"/>
                        @break
                        @case('disp_color')
                        <x-table-row.rows.bool :item="$item->disp_color"/>
                        @break
                        @case('disp_sens')
                        <x-table-row.rows.bool :item="$item->disp_sens"/>
                        @break
                        @case('gps')
                        <x-table-row.rows.bool :item="$item->gps"/>
                        @break
                        @case('nfc')
                        <x-table-row.rows.bool :item="$item->nfc"/>
                        @break
                        @case('heart_rate')
                        <x-table-row.rows.bool :item="$item->heart_rate"/>
                        @break
                        @case('blood_oxy')
                        <x-table-row.rows.bool :item="$item->blood_oxy"/>
                        @break
                        @case('blood_pressure')
                        <x-table-row.rows.bool :item="$item->blood_pressure"/>
                        @break
                        @case('smart_alarm')
                        <x-table-row.rows.bool :item="$item->smart_alarm"/>
                        @break
                        @case('camera_control')
                        <x-table-row.rows.bool :item="$item->camera_control"/>
                        @break
                        @case('player_control')
                        <x-table-row.rows.bool :item="$item->player_control"/>
                        @break
                        @case('grade_bracelet')
                        <x-table-row.rows.rating :item="$item->grade_bracelet"/>
                        @break
                        @case('country')
                        <x-table-row.rows.string :item="$item->country"/>
                        @break
                        @case('disp_tech')
                        <x-table-row.rows.string :item="$item->disp_tech"/>
                        @break
                        @case('disp_diag')
                        <x-table-row.rows.string :item="$item->disp_diag"/>
                        @break
                        @case('disp_resolution')
                        <x-table-row.rows.string :item="$item->disp_resolution"/>
                        @break
                        @case('phone_calls')
                        <x-table-row.rows.string :item="$item->phone_calls"/>
                        @break
                        @case('compatibility')
                        <x-table-row.rows.json :item="$item->compatibility"/>
                        @break
                        @case('protect_stand')
                        <x-table-row.rows.json :item="$item->protect_stand"/>
                        @break
                        @case('terms_of_use')
                        <x-table-row.rows.json :item="$item->terms_of_use"/>
                        @break
                    @endswitch
                @endforeach
                </tr>

            @endforeach

            </tbody>
        </table>
    </div>
</div>
