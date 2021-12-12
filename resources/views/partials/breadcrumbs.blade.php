@unless ($breadcrumbs->isEmpty())
<nav class="breadcrumbs text-sm" aria-label="Breadcrumbs">
  <ol class="flex flex-wrap gap-xxs">
      @foreach ($breadcrumbs as $breadcrumb)
          @if ($breadcrumb->url && !$loop->last)
            <li class="breadcrumbs__item">
                <a href="{{ $breadcrumb->url }}" class="color-inherit">{{ $breadcrumb->title }}</a>
                <svg class="icon margin-left-xxxs color-contrast-low" aria-hidden="true" viewBox="0 0 16 16"><polyline fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="6.5,3.5 11,8 6.5,12.5 "></polyline></svg>
            </li>
          @else
            <li class="breadcrumbs__item" aria-current="page">{{ $breadcrumb->title }}</li>
          @endif
      @endforeach
  </ol>
</nav>
@endunless