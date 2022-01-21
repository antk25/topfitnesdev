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
                             src="{{ $item->getFirstMediaUrl('bracelet', 'thumb') }}">
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
                        @case('grade_bracelet')
                        <x-table-row.rows.rating :item="$item->grade_bracelet"/>
                        @break
                        @case('country')
                        <x-table-row.rows.string :item="$item->country"/>
                        @break
                    @endswitch
                @endforeach
            </tr>
        @endforeach

        </tbody>
    </table>
</div>