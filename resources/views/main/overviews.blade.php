<div class="card-v10 card-v10--featured margin-y-md">
    <a class="card-v10__img-link radius-lg shadow-lg" href="{{ route('pub.overviews.show', ['overview' => $item]) }}">
    <img src="{{ $item->getFirstMediaUrl('covers') }}">
    </a>

    <div class="card-v10__content-wrapper">
    <div class="card-v10__content">
        <div class="card-v10__body">
        {{-- <p class="card-v10__label text-uppercase color-primary letter-spacing-md">Category</p> --}}

        <div class="text-component">
            <h1 class="card-v10__title"><a class="color-contrast-higher" href="{{ route('pub.overviews.show', ['rating' => $item]) }}">{{ $item->name }}</a></h1>
            <p class="card-v10__excerpt color-contrast-medium">{!! Str::words($item->description, 15) !!}</p>
        </div>
        </div>

        <footer class="card-v10__footer">
        <ul class="card-v10__social-list">
            <li class="card-v10__social-item">
            <button class="reset card-v10__social-btn js-tab-focus" aria-label="Like this content along with 120 other people">
                <svg class="icon" viewBox="0 0 12 12">
                <g>
                    <path d="M11.045,2.011a3.345,3.345,0,0,0-4.792,0c-.075.075-.15.225-.225.3-.075-.074-.15-.224-.225-.3a3.345,3.345,0,0,0-4.792,0,3.345,3.345,0,0,0,0,4.792l5.017,4.718L11.045,6.8A3.484,3.484,0,0,0,11.045,2.011Z"></path>
                </g>
                </svg>

                <span>120</span>
            </button>
            </li>

            <li class="card-v10__social-item">
            <button href="#comments" class="reset card-v10__social-btn js-tab-focus" aria-label="Comment">
                <svg class="icon" viewBox="0 0 12 12">
                <g>
                    <path d="M6,0C2.691,0,0,2.362,0,5.267s2.691,5.266,6,5.266a6.8,6.8,0,0,0,1.036-.079l2.725,1.485A.505.505,0,0,0,10,12a.5.5,0,0,0,.5-.5V8.711A4.893,4.893,0,0,0,12,5.267C12,2.362,9.309,0,6,0Z"></path>
                </g>
                </svg>

                <span>Комментарии</span>

            </button>
            </li>

        </ul>
        </footer>
    </div>
    </div>
</div>