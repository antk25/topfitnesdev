@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="pagination pagination--split padding-y-xl">
        <ol class="pagination__list flex flex-wrap gap-xxxs justify-center">
            @if ($paginator->onFirstPage())
            <li>
                <a href="#0" class="pagination__item pagination__item--disabled" aria-label="Go to previous page">
                  
                  <span>{!! __('pagination.previous') !!}</span>
                </a>
              </li>
            @else
            <li>
                <span wire:click="previousPage" wire:loading.attr="disabled" class="pagination__item pagination__item" aria-label="Go to previous page">
                  
                  <span>{!! __('pagination.previous') !!}</span>
                </span>
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
                                        <span wire:click="gotoPage({{ $page }})" class="pagination__item" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">{{ $page }}</span>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    @if ($paginator->hasMorePages())
                    <li>
                        <span wire:click="nextPage" wire:loading.attr="disabled" class="pagination__item" aria-label="Go to next page">
                          <span>{!! __('pagination.next') !!}</span>
                          
                        </span>
                      </li>
                    @else
                    <li>
                        <a href="#0" class="pagination__item pagination__item--disabled" aria-label="Go to next page">
                            
                            <span>{!! __('pagination.next') !!}</span>
                          </a>
                      </li>
                    @endif
                </ol>
               
    </nav>
@endif
