<td class="row-table__cell text-center">
    @if($item)
        <svg class="icon icon--sm" viewBox="0 0 24 24">
            <title>Option included</title>
            <circle cx="12" cy="12" r="12" fill="#6ad354" opacity="0.2" />
            <polyline points="6 12 10 16 19 7" fill="none" stroke="#57d339"
                      stroke-linecap="square" stroke-miterlimit="10" stroke-width="2" />
        </svg>
    @else
        <svg class="icon icon--sm" viewBox="0 0 24 24">
            <title>Option not included</title>
            <circle cx="12" cy="12" r="12" fill="#e25656" opacity="0.2" />
            <g fill="none" stroke="#d13b3b" stroke-linecap="square"
               stroke-miterlimit="10" stroke-width="2">
                <line x1="7" y1="17" x2="17" y2="7" />
                <line x1="17" y1="17" x2="7" y2="7" />
            </g>
        </svg>
    @endif
</td>



