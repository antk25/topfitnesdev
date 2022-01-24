<div class="margin-bottom-md">
    <table class="row-table row-table--expanded@xs width-100% js-row-table" aria-label="Table Example">
        <thead class="row-table__header">
        <tr class="row-table__row">
            <th class="row-table__cell row-table__cell--th text-right" aria-hidden="true"></th>
            @foreach ($bracelets as $item)
                <th class="row-table__cell row-table__cell--th">
                    <figure
                        class="width-lg height-lg radius-50% flex-shrink-0 overflow-hidden margin-x-auto margin-bottom-sm">
                        <img alt="Изображение {{ $item->name }}" class="block width-100% height-100% object-cover"
                             src="{{ $item->getFirstMediaUrl('bracelets', '320') }}">
                    </figure>
                    {{ $item->name }}
                </th>
            @endforeach
        </tr>
        </thead>

        <tbody class="row-table__body">

        @foreach($specs as $spec)
            <tr class="row-table__row">
                <th class="row-table__cell row-table__cell--th text-left">
                    <span class="row-table__th-inner">{{ $spec['value'] }}</span>
                </th>
                @foreach($bracelets as $item)
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
