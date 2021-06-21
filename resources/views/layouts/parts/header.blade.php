
<ul class="mega-nav__sub-items">
   @foreach ($items as $item)
      <li class="mega-nav__sub-item"><a href="#0" class="mega-nav__sub-link">{{ $item->name }}</a> {{ $item->group }}</li>
   @endforeach
</ul>