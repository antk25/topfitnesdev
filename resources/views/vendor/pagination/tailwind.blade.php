@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="pagination pagination--split padding-y-xl">
        <ol class="pagination__list flex flex-wrap gap-xxxs justify-center">
            @if ($paginator->onFirstPage())
            <li>
                <a href="#0" class="pagination__item pagination__item--disabled" aria-label="Go to previous page">
                  <svg class="icon margin-right-xxxs" aria-hidden="true" viewBox="0 0 16 16"><title>Previous</title><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="9.5,3.5 5,8 9.5,12.5 "></polyline></g></svg>
                  <span>{!! __('pagination.previous') !!}</span>
                </a>
              </li>
            @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}" class="pagination__item pagination__item" aria-label="Go to previous page">
                  <svg class="icon margin-right-xxxs" aria-hidden="true" viewBox="0 0 16 16"><title>Previous</title><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="9.5,3.5 5,8 9.5,12.5 "></polyline></g></svg>
                  <span>{!! __('pagination.previous') !!}</span>
                </a>
              </li>
            @endif

           
        

                       
                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                        <li class="display@sm" aria-hidden="true">
                            <span class="pagination__item pagination__item--ellipsis">{{ $element }}</span>
                        </li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="display@sm">
                                        <a href="#0" class="pagination__item pagination__item--selected" aria-label="Current Page, page 3" aria-current="page">{{ $page }}</a>
                                    </li>
                                @else
                                    <li class="display@sm">
                                        <a href="{{ $url }}" class="pagination__item" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    @if ($paginator->hasMorePages())
                    <li>
                        <a href="{{ $paginator->nextPageUrl() }}" class="pagination__item" aria-label="Go to next page">
                          <span>{!! __('pagination.next') !!}</span>
                          <svg class="icon margin-left-xxxs" aria-hidden="true" viewBox="0 0 16 16"><title>Next</title><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="6.5,3.5 11,8 6.5,12.5 "></polyline></g></svg>
                        </a>
                      </li>
                    @else
                    <li>
                        <a href="#0" class="pagination__item pagination__item--disabled" aria-label="Go to next page">
                            <svg class="icon margin-right-xxxs" aria-hidden="true" viewBox="0 0 16 16"><title>{!! __('pagination.next') !!}</title><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="6.5,3.5 11,8 6.5,12.5 "></polyline></g></svg>
                            <span>{!! __('pagination.next') !!}</span>
                          </a>
                      </li>
                    @endif
                </ol>
               
    </nav>
@endif
