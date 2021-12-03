@extends('admin.layouts.base')

@section('content')

    <form class="form-template-v3" method="POST" action="{{ route('specs.store') }}">
        @csrf
        <fieldset class="margin-bottom-md padding-bottom-md border-bottom">
            <div class="text-component margin-bottom-md text-center">
                <h2>Добавить характеристику</h2>
                <p>Добавление характеристик товаров.</p>
            </div>

            <div class="grid gap-xxs margin-bottom-xs">
                <div class="col-6@md">
                    <label class="form-label margin-bottom-xxxs" for="name">Название характеристики</label>

                    <div class="select">
                        <select class="select__input btn btn--subtle" name="name" id="name">
                            <option value="display_tech">Технология дисплея</option>
                            <option value="sensors">Датчики</option>
                            <option value="country">Страна</option>
                            <option value="material">Материал</option>
                            <option value="colors">Цвета</option>
                            <option value="monitoring">Мониторинг</option>
                            <option value="training_modes">Тренировочные режимы</option>
                            <option value="type_battery">Тип аккумулятора</option>
                            <option value="notifications">Уведомления</option>
                            <option value="phone_calls">Телефонные звонки</option>
                            <option value="bluetooth_versions">Версии Bluetooth</option>
                            {{-- 4.0, 4.1, 4.2, 5.0, 5.1, 5.2 --}}
                            <option value="interfaces">Другие интерфейсы</option>
                            <option value="protection_stands">Стандарты защиты</option>
                            <option value="charger">Зарядное устройство</option>
                            <option value="compatibility">Совместимость</option>
                            <option value="terms_of_use">Допустимые условия использования</option>
                            <option value="destination">Предназначение</option>
                        </select>

                        <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16">
                            <polyline points="1 5 8 12 15 5" fill="none" stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" />
                        </svg>
                    </div>



                    <label class="form-label margin-bottom-xxxs" for="device">Выбрать устройство:</label>

                    <div class="select">
                        <select class="select__input btn btn--subtle" name="device" id="device">
                            <option value="bracelet">Фитнес-браслет</option>
                            <option value="watch">Смарт-часы</option>
                            <option value="pulseoxi">Пульсоксиметр</option>
                        </select>

                        <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16">
                            <polyline points="1 5 8 12 15 5" fill="none" stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" />
                        </svg>
                    </div>


                    {{-- Add specs --}}
                    <section class="margin-bottom-md">
                        <div class="text-component">
                            <h4>Значения</h4>
                        </div>
                        <div class="js-repeater" data-repeater-input-name="allvalues[n]">
                            <div class="js-repeater__list">

                                <div class="grid gap-x-sm margin-y-md border radius-md padding-sm js-repeater__item">
                                    <div class="col-6@md">
                                        <input class="form-control" type="text" name="allvalues[0][value]"
                                            id="allvalues[0][value]" placeholder="Значение">

                                    </div>


                                    <div class="col-1@md">
                                        <button
                                            class="btn btn--subtle padding-x-xs col-content js-repeater__remove btn--accent"
                                            type="button">
                                            <svg class="icon" viewBox="0 0 20 20">
                                                <title>Remove item</title>

                                                <g fill="none" stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2">
                                                    <line x1="1" y1="5" x2="19" y2="5" />
                                                    <path d="M7,5V2A1,1,0,0,1,8,1h4a1,1,0,0,1,1,1V5" />
                                                    <path
                                                        d="M16,8l-.835,9.181A2,2,0,0,1,13.174,19H6.826a2,2,0,0,1-1.991-1.819L4,8" />
                                                </g>
                                            </svg>
                                        </button>

                                    </div>
                                </div>
                            </div>
                            <button class="btn btn--primary width-100% margin-top-xs js-repeater__add" type="button">+
                                Добавить значение</button>
                        </div>
                    </section>
                    {{-- End add specs --}}




                </div>

                <div class="col-6@md">

                </div>
            </div>
        </fieldset>

        <div class="text-right">
            <button type="submit" class="btn btn--primary">Отправить</button>
        </div>
    </form>
@endsection

@section('scripts')

    @parent

@endsection
