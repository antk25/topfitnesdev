<td class="row-table__cell text-center text-sm">
    @foreach ($item as $value)
        @if (!$loop->last)
            {{ $value }},
            @else
            {{ $value }}
        @endif
    @endforeach
</td>