@extends('admin.layouts.base')

@section('content')
<div class="text-component">
  <h1 class="text-lg">Отзывы</h1>
  <p class="text-sm color-contrast-medium">This is the main dashboard content.</p>
  <div class="bg radius-md padding-md shadow-xs">
    <p class="color-contrast-medium margin-bottom-sm">Таблица отзывов</p>
  
    <div class="int-table-actions padding-bottom-xxxs border-bottom border-contrast-lower" data-table-controls="table-1">
  
      <menu class="menu-bar js-int-table-actions__no-items-selected js-menu-bar">
        <li class="menu-bar__item menu-bar__item--trigger js-menu-bar__trigger" role="menuitem" aria-label="More options">
          <svg class="icon menu-bar__icon" aria-hidden="true" viewBox="0 0 16 16">
            <circle cx="8" cy="7.5" r="1.5" />
            <circle cx="1.5" cy="7.5" r="1.5" />
            <circle cx="14.5" cy="7.5" r="1.5" /></svg>
        </li>
  
        <li class="menu-bar__item " role="menuitem">
          <svg class="icon menu-bar__icon" aria-hidden="true" viewBox="0 0 16 16">
            <g>
              <path d="M8,3c1.179,0,2.311,0.423,3.205,1.17L8.883,6.492l6.211,0.539L14.555,0.82l-1.93,1.93 C11.353,1.632,9.71,1,8,1C4.567,1,1.664,3.454,1.097,6.834l1.973,0.331C3.474,4.752,5.548,3,8,3z"></path>
              <path d="M8,13c-1.179,0-2.311-0.423-3.205-1.17l2.322-2.322L0.906,8.969l0.539,6.211l1.93-1.93 C4.647,14.368,6.29,15,8,15c3.433,0,6.336-2.454,6.903-5.834l-1.973-0.331C12.526,11.248,10.452,13,8,13z"></path>
            </g>
          </svg>
          <span class="menu-bar__label">Refresh</span>
        </li>
  
        <li class="menu-bar__item " role="menuitem">
          <a href="{{ route('reviews.create') }}"><svg class="icon menu-bar__icon" aria-hidden="true" viewBox="0 0 16 16">
            <g>
              <path d="M15,16H1c-0.6,0-1-0.4-1-1V3c0-0.6,0.4-1,1-1h3v2H2v10h12V9h2v6C16,15.6,15.6,16,15,16z"></path>
              <path d="M10,3c-3.2,0-6,2.5-6,7c1.1-1.7,2.4-3,6-3v3l6-5l-6-5V3z"></path>
            </g>
          </svg>
          <span class="menu-bar__label">Export</span>
        </a>
        </li>
      </menu>
  
      <menu class="menu-bar is-hidden js-int-table-actions__items-selected js-menu-bar">
        <li class="menu-bar__item menu-bar__item--trigger js-menu-bar__trigger" role="menuitem" aria-label="More options">
          <svg class="icon menu-bar__icon" aria-hidden="true" viewBox="0 0 16 16">
            <circle cx="8" cy="7.5" r="1.5" />
            <circle cx="1.5" cy="7.5" r="1.5" />
            <circle cx="14.5" cy="7.5" r="1.5" /></svg>
        </li>
  
        <li class="menu-bar__item " role="menuitem">
          <svg class="icon menu-bar__icon" aria-hidden="true" viewBox="0 0 16 16">
            <g>
              <path d="M2,6v8c0,1.1,0.9,2,2,2h8c1.1,0,2-0.9,2-2V6H2z"></path>
              <path d="M12,3V1c0-0.6-0.4-1-1-1H5C4.4,0,4,0.4,4,1v2H0v2h16V3H12z M10,3H6V2h4V3z"></path>
            </g>
          </svg>
          <span class="menu-bar__label">Delete</span>
        </li>
  
        <li class="menu-bar__item " role="menuitem">
          <svg class="icon menu-bar__icon" aria-hidden="true" viewBox="0 0 16 16">
            <g>
              <path d="M15.977,4.887a.975.975,0,0,0-.04-.2.909.909,0,0,0-.089-.186,1.048,1.048,0,0,0-.048-.1l-3-4A1,1,0,0,0,12,0H4a1,1,0,0,0-.8.4l-3,4a1.048,1.048,0,0,0-.048.1.892.892,0,0,0-.089.187.957.957,0,0,0-.04.2A.885.885,0,0,0,0,5v9a2,2,0,0,0,2,2H14a2,2,0,0,0,2-2V5A.87.87,0,0,0,15.977,4.887ZM8,13.5,5,10H7V7H9v3h2ZM3,4,4.5,2h7L13,4Z"></path>
            </g>
          </svg>
          <span class="menu-bar__label">Archive</span>
        </li>
  
        <li class="menu-bar__item " role="menuitem">
          <svg class="icon menu-bar__icon" aria-hidden="true" viewBox="0 0 16 16">
            <g>
              <path d="M14.6,5.6l-8.2,8.2C6.9,13.9,7.5,14,8,14c3.6,0,6.4-3.1,7.6-4.9c0.5-0.7,0.5-1.6,0-2.3 C15.4,6.5,15,6.1,14.6,5.6z"></path>
              <path d="M14.3,0.3L11.6,3C10.5,2.4,9.3,2,8,2C4.4,2,1.6,5.1,0.4,6.9c-0.5,0.7-0.5,1.6,0,2.2c0.5,0.8,1.4,1.8,2.4,2.7 l-2.5,2.5c-0.4,0.4-0.4,1,0,1.4C0.5,15.9,0.7,16,1,16s0.5-0.1,0.7-0.3l14-14c0.4-0.4,0.4-1,0-1.4S14.7-0.1,14.3,0.3z M5.3,9.3 C5.1,8.9,5,8.5,5,8c0-1.7,1.3-3,3-3c0.5,0,0.9,0.1,1.3,0.3L5.3,9.3z"></path>
            </g>
          </svg>
          <span class="menu-bar__label">Hide</span>
        </li>
  
      </menu>
    </div>
  
    <div id="table-1" class="int-table text-sm js-int-table">
      <div class="int-table__inner">
        @if (count($reviews))
        <table class="int-table__table" aria-label="Interactive table example">
          <thead class="int-table__header js-int-table__header">
            <tr class="int-table__row">
              <td class="int-table__cell">
                <div class="custom-checkbox int-table__checkbox">
                  <input class="custom-checkbox__input js-int-table__select-all" type="checkbox" aria-label="Select all rows" />
                  <div class="custom-checkbox__control" aria-hidden="true"></div>
                </div>
              </td>
  
              <th class="int-table__cell int-table__cell--th int-table__cell--sort js-int-table__cell--sort">
                <div class="flex items-center">
                  <span>ID</span>
  
                  <svg class="icon icon--xxs margin-left-xxxs int-table__sort-icon" aria-hidden="true" viewBox="0 0 12 12">
                    <polygon class="arrow-up" points="6 0 10 5 2 5 6 0" />
                    <polygon class="arrow-down" points="6 12 2 7 10 7 6 12" /></svg>
                </div>
  
                <ul class="sr-only js-int-table__sort-list">
                  <li>
                    <input type="radio" name="sortingId" id="sortingIdNone" value="none" checked>
                    <label for="sortingIdNone">No sorting</label>
                  </li>
  
                  <li>
                    <input type="radio" name="sortingId" id="sortingIdAsc" value="asc">
                    <label for="sortingIdAsc">Sort in ascending order</label>
                  </li>
  
                  <li>
                    <input type="radio" name="sortingId" id="sortingIdDes" value="desc">
                    <label for="sortingIdDes">Sort in descending order</label>
                  </li>
                </ul>
              </th>
  
              <th class="int-table__cell int-table__cell--th int-table__cell--sort js-int-table__cell--sort">
                <div class="flex items-center">
                  <span>Название</span>
  
                  <svg class="icon icon--xxs margin-left-xxxs int-table__sort-icon" aria-hidden="true" viewBox="0 0 12 12">
                    <polygon class="arrow-up" points="6 0 10 5 2 5 6 0" />
                    <polygon class="arrow-down" points="6 12 2 7 10 7 6 12" /></svg>
                </div>
  
                <ul class="sr-only js-int-table__sort-list">
                  <li>
                    <input type="radio" name="sortingName" id="sortingNameNone" value="none" checked>
                    <label for="sortingNameNone">No sorting</label>
                  </li>
  
                  <li>
                    <input type="radio" name="sortingName" id="sortingNameAsc" value="asc">
                    <label for="sortingNameAsc">Sort in ascending order</label>
                  </li>
  
                  <li>
                    <input type="radio" name="sortingName" id="sortingNameDes" value="desc">
                    <label for="sortingNameDes">Sort in descending order</label>
                  </li>
                </ul>
              </th>
  
              <th class="int-table__cell int-table__cell--th int-table__cell--sort js-int-table__cell--sort">
                <div class="flex items-center">
                  <span>Title</span>
  
                  <svg class="icon icon--xxs margin-left-xxxs int-table__sort-icon" aria-hidden="true" viewBox="0 0 12 12">
                    <polygon class="arrow-up" points="6 0 10 5 2 5 6 0" />
                    <polygon class="arrow-down" points="6 12 2 7 10 7 6 12" /></svg>
                </div>
  
                <ul class="sr-only js-int-table__sort-list">
                  <li>
                    <input type="radio" name="sortingEmail" id="sortingEmailNone" value="none" checked>
                    <label for="sortingEmailNone">No sorting</label>
                  </li>
  
                  <li>
                    <input type="radio" name="sortingEmail" id="sortingEmailAsc" value="asc">
                    <label for="sortingEmailAsc">Sort in ascending order</label>
                  </li>
  
                  <li>
                    <input type="radio" name="sortingEmail" id="sortingEmailDes" value="desc">
                    <label for="sortingEmailDes">Sort in descending order</label>
                  </li>
                </ul>
              </th>
  
              <th class="int-table__cell int-table__cell--th text-left">
                Description
              </th>
  
              <th class="int-table__cell int-table__cell--th int-table__cell--sort js-int-table__cell--sort" data-date-format="dd-mm-yyyy">
                <div class="flex items-center">
                  <span>Добавлен</span>
  
                  <svg class="icon icon--xxs margin-left-xxxs int-table__sort-icon" aria-hidden="true" viewBox="0 0 12 12">
                    <polygon class="arrow-up" points="6 0 10 5 2 5 6 0" />
                    <polygon class="arrow-down" points="6 12 2 7 10 7 6 12" /></svg>
                </div>
  
                <ul class="sr-only js-int-table__sort-list">
                  <li>
                    <input type="radio" name="sortingDate" id="sortingDateNone" value="none" checked>
                    <label for="sortingDateNone">No sorting</label>
                  </li>
  
                  <li>
                    <input type="radio" name="sortingDate" id="sortingDateAsc" value="asc">
                    <label for="sortingDateAsc">Sort in ascending order</label>
                  </li>
  
                  <li>
                    <input type="radio" name="sortingDate" id="sortingDateDes" value="desc">
                    <label for="sortingDateDes">Sort in descending order</label>
                  </li>
                </ul>
              </th>
                <th class="int-table__cell int-table__cell--th text-left">Action</th>
            </tr>
          </thead>
  
          <tbody class="int-table__body js-int-table__body">
            @foreach ($reviews as $review)
            <tr class="int-table__row">
              <th class="int-table__cell" scope="row">
                <div class="custom-checkbox int-table__checkbox">
                  <input class="custom-checkbox__input js-int-table__select-row" type="checkbox" aria-label="Select this row" />
                  <div class="custom-checkbox__control" aria-hidden="true"></div>
                </div>
              </th>
              <td class="int-table__cell">{{ $review->id }}</td>
              <td class="int-table__cell"><a href="{{ route('reviews.edit', ['review' => $review->id]) }}">{{ $review->name }}</a></td>
              <td class="int-table__cell"></td>
              <td class="int-table__cell max-width-xxxxs">{{ $review->review_text }}</td>
              <td class="int-table__cell">{{ $review->created_at->diffForHumans() }}</td>
              <td class="int-table__cell">

                <form method="POST" action="{{ route('reviews.destroy', ['review' => $review->id]) }}">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn--primary text-sm">Удалить</button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>

        @else
         <p>Таблица брендов пустая</p>
        @endif
      </div>
    </div>
  
  
    <div class="flex items-center justify-between padding-top-sm">
      <p class="text-sm">450 results</p>
  
      {{ $reviews->links() }}
      {{-- <nav class="pagination text-sm" aria-label="Pagination">
        <ul class="pagination__list flex flex-wrap gap-xxxs">
          <li>
            <a href="#0" class="pagination__item">
              <svg class="icon" viewBox="0 0 16 16">
                <title>Go to previous page</title>
                <g stroke-width="1.5" stroke="currentColor">
                  <polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="9.5,3.5 5,8 9.5,12.5 "></polyline>
                </g>
              </svg>
            </a>
          </li>
  
          <li>
            <span class="pagination__jumper flex items-center">
              <input aria-label="Page number" class="form-control" type="text" id="pageNumber" name="pageNumber" value="1">
              <em>of 50</em>
            </span>
          </li>
  
          <li>
            <a href="#0" class="pagination__item">
              <svg class="icon" viewBox="0 0 16 16">
                <title>Go to next page</title>
                <g stroke-width="1.5" stroke="currentColor">
                  <polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="6.5,3.5 11,8 6.5,12.5 "></polyline>
                </g>
              </svg>
            </a>
          </li>
        </ul>
      </nav> --}}
    </div>
  </div>

</div>
@endsection 