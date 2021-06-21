@foreach ($items as $item)
   <ul class="mega-nav__sub-items">
        <li class="mega-nav__label">{{ $item->name }}</li>
            @foreach ($item->menuitems as $menuitem)
                <li class="mega-nav__sub-item"><a href="#0" class="mega-nav__sub-link">{{ $menuitem->name }}</a> </li>
            @endforeach
   </ul>
@endforeach