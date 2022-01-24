
<td class="row-table__cell text-center">
    @foreach ($item as $value)
        @if (!$loop->last)
            {{ $value }},
            @else
            {{ $value }}
        @endif
    @endforeach
</td>