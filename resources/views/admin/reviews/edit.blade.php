@extends('admin.layouts.base')

@section('styles')
    @parent
    <link rel="stylesheet" href="{{ asset('css/admin/trix.css') }}">
@endsection


@section('content')

<form class="form-template-v3" method="POST" action="{{ route('reviews.update', ['review' => $review->id]) }}">
    @csrf
    @method('PUT')

    {{-- Сообщение об успешности сохранения --}}
    @if(session('success'))

        <div class="alert alert--success alert--is-visible padding-sm radius-md js-alert" role="alert">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="icon icon--sm alert__icon margin-right-xxs" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12,0A12,12,0,1,0,24,12,12.035,12.035,0,0,0,12,0ZM10,17.414,4.586,12,6,10.586l4,4,8-8L19.414,8Z"></path>
                    </svg>

                    <p class="text-sm"><strong>Успешно:</strong> {{ session('success') }}.</p>
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
    {{-- Конец сообщения об успешности сохранения --}}


    <div class="bg radius-md shadow-xs padding-md margin-bottom-md">

        {{-- select good --}}
        <div class="margin-bottom-sm">
            <div class="grid gap-xxs">
                <div class="col-3@lg">
                    <label class="inline-block text-sm padding-top-xs@lg" for="item_id">Товар</label>
                </div>

                <div class="col-6@lg">
                    <input class="form-control width-100%" type="text" name="item_id" id="item_id" value="{{ $review->reviewable->name }}" readonly>
                </div>
            </div>
        </div>
        {{-- end select good --}}
    </div>

    <div class="emoji-rate bg radius-md js-emoji-rate">
        <div class="padding-md text-center">
            <p class="margin-bottom-xs">Написать отзыв</p>
            <ul class="emoji-rate__list inline-flex gap-xs">
                <li>
                    <input id="emoji-rate-option-no" class="sr-only emoji-rate__native-input" type="radio" name="rating_user" value="1" @if ($review->rating_user == 1)checked @endif>

                    <label class="emoji-rate__custom-input emoji-rate__custom-input--no" for="emoji-rate-option-no">
                        <span class="sr-only">No</span>

                        <svg class="emoji-rate__icon" viewBox="0 0 40 40" aria-hidden="true">
                            <circle id="emoji-rate-no-bg" cx="20" cy="20" r="20" fill="var(--color-contrast-lower)" />
                            <g id="emoji-rate-no-eyes">
                                <circle cx="11.5" cy="19.5" r="2.5" fill="currentColor" />
                                <path d="M7,15a18.059,18.059,0,0,0,4,2,18.06,18.06,0,0,0,5,1" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                <circle cx="28.5" cy="19.5" r="2.5" fill="currentColor" />
                                <path d="M33,15a18.059,18.059,0,0,1-4,2,18.06,18.06,0,0,1-5,1" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </g>
                            <path id="emoji-rate-no-mouth" d="M16,29a5,5,0,0,1,8,0" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </svg>
                    </label>
                </li>

                <li>
                    <input id="emoji-rate-option-partially" class="sr-only emoji-rate__native-input" type="radio" name="rating_user" value="2" @if ($review->rating_user == 2)checked @endif>

                    <label class="emoji-rate__custom-input emoji-rate__custom-input--partially" for="emoji-rate-option-partially">
                        <span class="sr-only">Partially</span>

                        <svg class="emoji-rate__icon" viewBox="0 0 40 40" aria-hidden="true">
                            <circle id="emoji-rate-partially-bg" cx="20" cy="20" r="20" fill="var(--color-contrast-lower)" />
                            <g id="emoji-rate-partially-eyes">
                                <circle cx="11.5" cy="19.5" r="2.5" fill="currentColor" />
                                <circle cx="28.5" cy="19.5" r="2.5" fill="currentColor" />
                            </g>
                            <line id="emoji-rate-partially-mouth" x1="15" y1="28" x2="25" y2="28" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                        </svg>
                    </label>

                    <svg class="emoji-rate__hand-icon" viewBox="0 0 40 40" aria-hidden="true">
                        <path id="emoji-rate-partially-hand" d="M17.279,28.031,4.323,29.1l-.33-3.986a2,2,0,0,0-3.986.33l.825,9.966a5.005,5.005,0,0,0,5.4,4.57l3.987-.33a3,3,0,0,0,2.742-3.237l-.33-3.986,4.983-.413a2,2,0,1,0-.33-3.986Z" fill="#e2ac4b"/>
                    </svg>
                </li>

                <li>
                    <input id="emoji-rate-option-yes" class="sr-only emoji-rate__native-input" type="radio" name="rating_user" value="3" @if ($review->rating_user == 3)checked @endif>

                    <label class="emoji-rate__custom-input emoji-rate__custom-input--yes" for="emoji-rate-option-yes">
                        <span class="sr-only">Yes</span>

                        <svg class="emoji-rate__icon" viewBox="0 0 40 40" aria-hidden="true">
                            <circle id="emoji-rate-yes-bg" cx="20" cy="20" r="20" fill="var(--color-contrast-lower)" />
                            <g id="emoji-rate-yes-eyes">
                                <path d="M9,19a3,3,0,0,1,6,0" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                <path d="M31,19a3,3,0,0,0-6,0" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </g>
                            <g id="emoji-rate-yes-mouth">
                                <path d="M26,25H14a1,1,0,0,0-1,1,7,7,0,0,0,14,0A1,1,0,0,0,26,25Z" fill="currentColor" />
                                <path id="emoji-rate-yes-tongue" d="M20,29a9.942,9.942,0,0,0-5.317,1.541,6.978,6.978,0,0,0,10.634,0A9.942,9.942,0,0,0,20,29Z" fill="var(--color-contrast-medium)" />
                            </g>
                        </svg>
                    </label>
                </li>
            </ul>
        </div>

        <div class="overflow-hidden padding-y-md padding-x-md js-emoji-rate__comment">
            <div class="grid gap-xxs margin-bottom-sm">
                <div class="col-6@md">
                    <input class="form-control width-100% @error('name') form-control--error @enderror" type="text" name="name" id="name" placeholder="Имя" value="{{ $review->name }}">
                    @error('name')
                    <div role="alert" class="bg-error bg-opacity-20% padding-xxxs radius-md text-xs color-contrast-higher margin-top-xxs"><p><strong>ошибка:</strong> {{ $message }}</p></div>
                    @enderror
                </div>

                <div class="col-6@md">
                    <input class="form-control width-100% @error('email') form-control--error @enderror" type="email" name="email" id="email" placeholder="email@myemail.com" value="{{ $review->email }}">
                    @error('email')
                    <div role="alert" class="bg-error bg-opacity-20% padding-xxxs radius-md text-xs color-contrast-higher margin-top-xxs"><p><strong>ошибка:</strong> {{ $message }}</p></div>
                    @enderror
                </div>
            </div>

                <div class="select">
                    <select class="select__input form-control" name="period_use" id="period_use">
                        <option value="">Период владения браслетом</option>
                        <option value="Несколько дней" @if ($review->period_use == 'Несколько дней') selected @endif>Несколько дней</option>
                        <option value="Более 2-х недель" @if ($review->period_use == 'Более 2-х недель') selected @endif>Более 2-х недель</option>
                        <option value="Более месяца" @if ($review->period_use == 'Более месяца') selected @endif>Более месяца</option>
                        <option value="Более полугода" @if ($review->period_use == 'Более полугода') selected @endif>Более полугода</option>
                    </select>

                    <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16">
                        <g stroke-width="1" stroke="currentColor">
                            <polyline fill="none" stroke="currentColor" stroke-linecap="round"
                                      stroke-linejoin="round" stroke-miterlimit="10"
                                      points="15.5,4.5 8,12 0.5,4.5 "></polyline>
                        </g>
                    </svg>
                </div>


            <label class="inline-block text-sm color-contrast-medium margin-bottom-xs" for="emoji-rate-msg">Напишите свои впечателения о товаре</label>

            <textarea class="form-control width-100% hide" rows="4" name="review_text" id="review_text">{{ $review->review_text }}</textarea>
            @include('admin.layouts.parts.trixeditor')
            @error('review_text')
            <div role="alert" class="bg-error bg-opacity-20% padding-xxxs radius-md text-xs color-contrast-higher margin-top-xxs"><p><strong>ошибка:</strong> {{ $message }}</p></div>
            @enderror

            <div class="margin-top-xs text-right">
                <button type="submit" class="btn btn--primary">Отправить</button>
            </div>
        </div>
    </div>
  </form>
@endsection

@section('scripts')
    @parent
    <script src="{{ asset("js/admin/trix.js") }}"></script>
@endsection

