@extends('layouts.base')

@section('content')
<div class="container max-width-adaptive-lg padding-top-md">
  <nav class="breadcrumbs text-sm" aria-label="Breadcrumbs">
    <ol class="flex flex-wrap gap-xxs">
      <li class="breadcrumbs__item">
        <a href="/" class="color-inherit"><svg class="icon margin-right-xxxs" viewBox="0 0 16 16" aria-hidden="true"><g fill="none" stroke-width="1" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><polyline points=" 15.5,7.5 8,0.5 0.5,7.5 "></polyline><polyline points="2.5,8.5 2.5,15.5 6.5,15.5 6.5,11.5 9.5,11.5 9.5,15.5 13.5,15.5 13.5,8.5 "></polyline></g></svg></a>
        <svg class="icon margin-left-xxxs color-contrast-medium" aria-hidden="true" viewBox="0 0 16 16"><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="6.5,3.5 11,8 6.5,12.5 "></polyline></g></svg>
      </li>
  
      <li class="breadcrumbs__item">
        <a href="{{ route('pub.bracelets.index') }}" class="color-inherit">Каталог</a>
        <svg class="icon margin-left-xxxs color-contrast-medium" aria-hidden="true" viewBox="0 0 16 16"><g stroke-width="1" stroke="currentColor"><polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="6.5,3.5 11,8 6.5,12.5 "></polyline></g></svg>
      </li>
  
      <li class="breadcrumbs__item" aria-current="page">{{ $bracelet->name }}</li>
    </ol>
  </nav>
<div class="margin-y-sm text-component">
  <h1>{{ $bracelet->name }}</h1>
</div>

  <div class="grid gap-xxs">
    <div class="col-6@md">
<ul class="exp-gallery grid gap-xs js-exp-gallery" data-controls="expLightbox" data-placeholder="assets/img/expandable-img-gallery-placeholder.svg">
   @foreach ($media as $image)
   <li class="col-4 col-3@sm js-exp-gallery__item">
     <figure class="aspect-ratio-1:1">
       <img src="{{ $image->getFullUrl('320') }}" data-modal-src="{{ $image->getFullUrl('320') }}" alt="Image Description">
       <figcaption class="sr-only js-exp-gallery__caption">Image caption</figcaption>
     </figure>
   </li>
   @endforeach
  </ul>
    </div>
    <div class="col-6@md">

<div class="table-card bg radius-md padding-md shadow-xs">
  <div class="margin-bottom-md">
    <div class="flex items-baseline justify-between">
      <p class="color-contrast-medium">Оценки</p>
      <p>Общая оценка <span class="text-md color-primary font-bold">14.3</span></p>
    </div>
  </div>

  <div class="tbl text-sm">
    <table class="tbl__table" aria-label="Таблица оценок">
      <thead class="tbl__header sr-only">
        <tr class="tbl__row">
          <th class="tbl__cell text-left" scope="col">
            <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Оценка</span>
          </th>

          <th class="tbl__cell text-right" scope="col">
            <span class="text-xs text-uppercase letter-spacing-lg font-semibold">Значение</span>
          </th>
        </tr>
      </thead>

      <tbody class="tbl__body">
        @foreach ($bracelet->grades as $grade)
        <tr class="tbl__row">
          <td class="tbl__cell" role="cell"><span class="tooltip-trigger js-tooltip-trigger" title="{{ $grade->about }}">{{ $grade->name }}</span></td>


          <td class="tbl__cell" role="cell">
            <div class="flex justify-end">

              <div class="progress-bar inline-flex items-center js-progress-bar">
                <p class="sr-only" aria-live="polite" aria-atomic="true">Progress value is <span class="js-progress-bar__aria-value">{{ $grade->pivot->value * 10 }}%</span></p>

                <span class="progress-bar__value margin-left-xs order-2 font-bold" aria-hidden="true">
                     {{ number_format($grade->pivot->value, 1) }}
                </span>

                <div class="progress-bar__bg order-1" aria-hidden="true">
                  <div class="progress-bar__fill color-success" style="width: {{ $grade->pivot->value * 10 }}%;"></div>
                </div>
              </div>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
    </div>
  </div>
  

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
         {{ $material }}<br>
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

@section('footerScripts')
@parent
<script>

  function reviewForm() {
    return {
      formData: {
        name: '',
        email: '',
        rating_user: '',
        period_use: '',
        review_text: ''
      },
      
      message: '',
      errorsName: '',
      errorsEmail: '',
      errorsRating: '',
      errorsReview: '',

      submitData() {

        axios
        ({
          url: '/katalog/{{ $bracelet->id }}/review',
          method: 'post',
          headers: { 'X-CSRFToken': '{{ csrf_token() }}' },
          data: this.formData
        }).catch(error => {
                    if (error.response.status === 422) {
                        this.errorsName = error.response.data.errors.name;
                        this.errorsEmail = error.response.data.errors.email;
                        this.errorsRating = error.response.data.errors.rating_user;
                        this.errorsReview = error.response.data.errors.review_text;                        
                        // document.getElementById('revi').remove();
                        // console.log(error.response.data.errors);
                        // this.errors.title = error.response.data.errors.title
                        // this.errors.description = error.response.data.errors.description
                    }
                }).then(response => {
                  if (response.status === 200) {
                    this.formData = '';
                    this.message = 'Form sucessfully submitted!';
                    let event = new CustomEvent("toggle");
                        window.dispatchEvent(event);
                  }
                  })
              },

            }
          }

        function allReviews() {
          
          // lastUpdate: Date.now();

            return {
              
            reviews: '',
            
            submitReviews() {
              
                axios
              ({
                url: '/katalog/{{ $bracelet->id }}/reviews',
                method: 'get',
                responseType: 'text',
              }).then(response => {
                  this.reviews = response.data,
                  console.log(response.data);
                })

              }
            }
          }
        </script>
@endsection


