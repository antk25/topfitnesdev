@extends('layouts.base')

@section('content')
<div class="container max-width-adaptive-lg padding-top-md">

  <h1>{{ $bracelet->title }}</h1>

  <img src="{{ $bracelet->image('bracelet_shot', 'flexible') }}">

  <ul class="exp-gallery grid gap-xs js-exp-gallery" data-controls="expLightbox" data-placeholder="assets/img/expandable-img-gallery-placeholder.svg">
   @foreach ($bracelet->images('gallery') as $gallery)
   <li class="col-4 col-3@sm js-exp-gallery__item">
     <figure class="aspect-ratio-1:1">
       <img src="{{ $gallery }}" data-modal-src="{{ $gallery }}" alt="Image Description">
       <figcaption class="sr-only js-exp-gallery__caption">Image caption</figcaption>
     </figure>
   </li>
   @endforeach
  </ul>

  <div id="expLightbox" class="modal exp-lightbox bg js-modal js-exp-lightbox" data-animation="on" data-modal-first-focus=".js-exp-lightbox__body">
   <div class="exp-lightbox__content pointer-events-none">
     <header class="exp-lightbox__header">
       <h3 class="exp-lightbox__title pointer-events-auto">Галерея</h2>

       <menu class="menu-bar menu-bar--expanded@md pointer-events-auto js-menu-bar" data-menu-class="menu--overlay">
         <li class="menu-bar__item menu-bar__item--trigger js-menu-bar__trigger" role="menuitem" aria-label="More options">
           <svg class="icon menu-bar__icon" aria-hidden="true" viewBox="0 0 16 16"><circle cx="8" cy="7.5" r="1.5" /><circle cx="1.5" cy="7.5" r="1.5" /><circle cx="14.5" cy="7.5" r="1.5" /></svg>
         </li>

         <li class="menu-bar__item js-modal__close" role="menuitem">
           <svg class="icon menu-bar__icon" aria-hidden="true" viewBox="0 0 24 24"><g stroke-linecap="square" stroke-linejoin="miter" stroke-miterlimit="10" stroke-width="2" stroke="currentColor" fill="none"><line x1="19" y1="5" x2="5" y2="19"></line><line x1="19" y1="19" x2="5" y2="5"></line></g></svg>
           <span class="menu-bar__label reset">Закрыть</span>
         </li>
       </menu>
     </header>

     <div class="exp-lightbox__body slideshow slideshow--transition-slide js-exp-lightbox__body" data-swipe="on" data-navigation="off" data-zoom="on">
       <ul class="slideshow__content js-exp-lightbox__slideshow">
         <!-- gallery created in JS -->
       </ul>

       <ul>
         <li class="slideshow__control js-slideshow__control">
           <button class="reset slideshow__btn pointer-events-auto js-tab-focus">
             <svg class="icon" viewBox="0 0 32 32"><title>Show previous slide</title><path d="M20.768,31.395L10.186,16.581c-0.248-0.348-0.248-0.814,0-1.162L20.768,0.605l1.627,1.162L12.229,16 l10.166,14.232L20.768,31.395z"></path></svg>
           </button>
         </li>

         <li class="slideshow__control js-slideshow__control">
           <button class="reset slideshow__btn pointer-events-auto js-tab-focus">
             <svg class="icon" viewBox="0 0 32 32"><title>Show next slide</title><path d="M11.232,31.395l-1.627-1.162L19.771,16L9.605,1.768l1.627-1.162l10.582,14.813 c0.248,0.348,0.248,0.814,0,1.162L11.232,31.395z"></path></svg>
           </button>
         </li>
       </ul>
     </div>
   </div>
 </div>



 <table class="prop-table width-100%" aria-label="Характеристики {{ $bracelet->title }}">
   <tbody class="prop-table__body">

     <tr class="text-md text-bold">
       <th class="text-center color-primary padding-y-sm" colspan="2">Общие</th>
     </tr>

     <tr class="prop-table__row">
       <th class="prop-table__cell prop-table__cell--th">Год выпуска</th>
       <td class="prop-table__cell">{{ $bracelet->year }}</td>
     </tr>

     <tr class="prop-table__row">
       <th class="prop-table__cell prop-table__cell--th">Материал ремешка</th>
       <td class="prop-table__cell">
         @foreach ($bracelet->material as $material)
         {{ $material['id'] }}<br>
         @endforeach
       </td>
     </tr>

     <tr class="prop-table__row">
       <th class="prop-table__cell prop-table__cell--th">Постоянное измерение
         пульса</th>
       <td class="prop-table__cell">
         @if ($bracelet->pulse_permanent == '1')
         <svg class="icon icon--md" viewBox="0 0 48 48"><title>Option available</title><path d="M24,47A23,23,0,1,1,47,24,23.026,23.026,0,0,1,24,47Z" fill="#87c458"/><polyline points="12 24 20 32 36 16" fill="none" stroke="#fff" stroke-linecap="square" stroke-miterlimit="10" stroke-width="4"/></svg>
         @else
         <svg class="icon icon--md" viewBox="0 0 48 48"><title>Option not available</title><path d="M24,47A23,23,0,1,1,47,24,23.026,23.026,0,0,1,24,47Z" fill="#f54250"/><line x1="33" y1="15" x2="15" y2="33" fill="none" stroke="#fff" stroke-linecap="square" stroke-miterlimit="10" stroke-width="4"/><line x1="15" y1="15" x2="33" y2="33" fill="none" stroke="#fff" stroke-linecap="square" stroke-miterlimit="10" stroke-width="4"/></svg>
          @endif

     </tr>

   </tbody>
 </table>

 <h2>Отзывы</h2>

 <section class="comments comments--no-profile-img">
  @section('comments')
  <div class="margin-bottom-lg">
    <div class="flex gap-sm flex-column flex-row@md justify-between items-center@md">
      <div>
        <h1 class="text-md">Comments</h1>
      </div>

      <form aria-label="Choose sorting option">
        <div class="flex flex-wrap gap-sm text-sm">
          <div class="position-relative">
            <input class="comments__sorting-label" type="radio" name="sortComments" id="sortCommentsPopular" checked>
            <label for="sortCommentsPopular">Popular</label>
          </div>

          <div class="position-relative">
            <input class="comments__sorting-label" type="radio" name="sortComments" id="sortCommentsNewest">
            <label for="sortCommentsNewest">Newest</label>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div x-data="allReviews()" x-init="submitReviews()" x-on:toggle.window="submitReviews()">
      <div x-html="reviews"></div>
  </div>

  
  @show
  
  @include('forms.review')

  </section>
</div>
@endsection



