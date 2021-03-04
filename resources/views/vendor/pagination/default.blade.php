@if ($paginator->hasPages())
    <nav class="pagination text-sm" aria-label="Pagination">
        <ul class="pagination__list flex flex-wrap gap-xxxs">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" class="pagination__item" aria-label="@lang('pagination.previous')">
                    <svg class="icon" viewBox="0 0 16 16">
                        <title>Go to previous page</title>
                        <g stroke-width="1.5" stroke="currentColor">
                        <polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="9.5,3.5 5,8 9.5,12.5 "></polyline>
                        </g>
                    </svg>
                    </a>
                </li>
            @endif
            
            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li>
                        <span class="pagination__jumper flex items-center">
                        <input aria-label="Page number" class="form-control" type="text" id="pageNumber" name="pageNumber" value="{{ $element }}">
                        </span>
                    </li>
                @endif
                
                {{-- Array Of Links --}}
                @if (is_array($element))
                <li>
                    <span class="pagination__jumper flex items-center">
                    <input aria-label="Page number" class="form-control" type="text" id="pageNumber" name="pageNumber" value="{{ $page }}">
                    <em>of 50</em>
                    </span>
                </li>
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="pagination__item" aria-label="@lang('pagination.next')">
                <svg class="icon" viewBox="0 0 16 16">
                    <title>Go to next page</title>
                    <g stroke-width="1.5" stroke="currentColor">
                    <polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="6.5,3.5 11,8 6.5,12.5 "></polyline>
                    </g>
                </svg>
                </a>
            </li>
            @else
                
            @endif


            
        </ul>
    </nav>
@endif
