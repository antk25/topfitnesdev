<div>
  @if ($comments->count())
<section class="comments">
  <div class="margin-bottom-sm">
    <h2 class="text-md">Комментарии</h2>
  </div>
  <ul class="margin-bottom-lg">
    @foreach ($comments as $comment)
    @include('livewire.comments.show', ['comment' => $comment])
    @if($comment->replies->count() > 0)
    <div class="border-left border-3 border-opacity-20%">
      <ul class="margin-left-sm margin-top-sm">
        @include('livewire.comments.index', ['reply' => $comment->replies])
      </ul>
    </div>
    @endif
</li>

  @endforeach
  </ul>
  @if (session()->has('message'))
<div class="alert alert--success alert--is-visible padding-sm radius-md js-alert" role="alert">
  <div class="flex items-center justify-between">
    <div class="flex items-center">
      <svg class="icon icon--sm alert__icon margin-right-xxs" viewBox="0 0 24 24" aria-hidden="true">
        <path d="M12,0A12,12,0,1,0,24,12,12.035,12.035,0,0,0,12,0ZM10,17.414,4.586,12,6,10.586l4,4,8-8L19.414,8Z"></path>
      </svg>

      <p class="text-sm">{{ session('message') }}.</p>
    </div>
  
    <button class="reset alert__close-btn margin-left-sm js-alert__close-btn js-tab-focus">
      <svg class="icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
        <title>Close alert</title>
        <line x1="3" y1="3" x2="17" y2="17" />
        <line x1="17" y1="3" x2="3" y2="17" />
      </svg>
    </button>
  </div>
</div>


  @endif

  
  </section>

  @endif
  <section class="form-comment">
    @if($commentIdReply == '')
<form wire:submit.prevent="store()">
    <fieldset>
      <legend class="form-legend">Написать комментарий</legend>
      @if($user == '')
    <div class="input-merger form-control width-100% grid">
      <input type="text" class="reset input-merger__input min-width-0 col" name="username" wire:model="name" id="username" placeholder="Ваше имя">
      <input type="email" class="reset input-merger__input min-width-0 col" name="useremail" wire:model="email" id="useremail" placeholder="Email">
    </div> 
    <p class="text-xs color-contrast-medium margin-top-xxxxs">Укажите <span class="text-bold">имя</span> и <span class="text-bold">email</span>, либо <a href="#" aria-controls="modal-form">зарегистрируйтесь</a>.</p> 
    @endif
      <div class="margin-y-xs">
        <label class="sr-only" for="commentNewContent">Ваш комментарий</label>
        <textarea class="form-control width-100%" wire:model.lazy="comment"></textarea>
      </div>
    </fieldset>
    
    <button class="btn btn--primary" type="submit">Написать</button>
  </form>
  @endif 
  </section>
</div>

<div class="modal modal--animate-scale flex flex-center bg-contrast-higher bg-opacity-90% padding-md js-modal" id="modal-form">
  <div class="modal__content width-100% max-width-xs max-height-100% overflow-auto padding-md bg radius-md shadow-md" role="alertdialog" aria-labelledby="modal-form-title" aria-describedby="modal-form-description">
    <div class="text-component margin-bottom-md">
      <h3 id="modal-form-title">Join our Newsletter</h3>
      <p id="modal-form-description">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Suscipit asperiores molestiae ex.</p>
    </div>

    <form class="sign-up-form" method="POST" action="{{ route('register') }}">
        @csrf
        <div class="text-component text-center margin-bottom-sm">
          <h1>Регистрация</h1>
          <p>Зарегистрироваться на сайте<br>
          У вас уже есть аккаунт? <a href="{{ route('login') }}">Войти</a></p>
        </div>
                  
        <div class="margin-bottom-sm">
          <label class="form-label margin-bottom-xxxs" for="name">Имя</label>
          <input class="form-control width-100%" type="text" id="name" name="name" value="{{ old('name') }}" autocomplete="name">
          @error('name')
          <div role="alert" class="bg-error bg-opacity-20% padding-xs radius-md text-sm color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
          @enderror
        </div>
      
        <div class="margin-bottom-sm">
          <label class="form-label margin-bottom-xxxs" for="email">Email</label>
          <input class="form-control width-100%" type="email" name="email" id="email" value="{{ old('email') }}" autocomplete="email">
          @error('email')
          <div role="alert" class="bg-error bg-opacity-20% padding-xs radius-md text-sm color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
          @enderror
        </div>
      
        <div class="margin-bottom-md">
          <label class="form-label margin-bottom-xxxs" for="password">Пароль</label> 
          <input class="form-control width-100%" type="password" name="password" id="password" autocomplete="new-password">
          @error('password')
          <div role="alert" class="bg-error bg-opacity-20% padding-xs radius-md text-sm color-contrast-higher margin-top-xxs"><p><strong>Ошибка:</strong> {{ $message }}</p></div>
          @enderror
          <p class="text-xs color-contrast-medium margin-top-xxs">Минимальная длина 6 символов</p>
        </div>

        <div class="margin-bottom-md">
          <label class="form-label margin-bottom-xxxs" for="password-confirm">Повторите пароль</label> 
          <input class="form-control width-100%" type="password" name="password_confirmation" id="password-confirm" autocomplete="new-password">
         
        </div>
      
        {{-- <div class="margin-bottom-md">
          <input class="checkbox" type="checkbox" id="check-newsletter">
          <label for="check-newsletter">Send me updates about {productName}</label>
        </div> --}}
      
        <div class="margin-bottom-sm">
          <button class="btn btn--primary btn--md width-100%">Зарегистрироваться</button>
        </div>
      
        <div class="text-center">
          <p class="text-xs color-contrast-medium">Регистрируясь вы принимаете <a href="#0">Пользовательскте соглашение</a> и <a href="#0">Политику конфиденциальности</a>.</p>
        </div>
      </form>

    <div class="text-component">
      <p class="text-xs color-contrast-medium">Lorem ipsum dolor sit, amet <a href="#0" class="color-contrast-high">consectetur adipisicing</a> elit. Nisi molestias hic voluptatibus.</p>
    </div>
  </div>

  <button class="reset modal__close-btn modal__close-btn--outer  js-modal__close js-tab-focus">
    <svg class="icon icon--sm" viewBox="0 0 24 24">
      <title>Close modal window</title>
      <g fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="3" y1="3" x2="21" y2="21" />
        <line x1="21" y1="3" x2="3" y2="21" />
      </g>
    </svg>
  </button>
</div>

