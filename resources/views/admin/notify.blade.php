
@extends('admin.layouts.base')

@section('content')
<div class="margin-bottom-md">
    <h1 class="text-lg">Уведомления</h1>
  </div>

  <div class="bg radius-md shadow-xs">
    <div class="border-bottom border-contrast-lower padding-md text-right">
      <div class="flex flex-wrap gap-sm justify-between items-center">
        <p>{{ count($notifs) }} уведомлений</p>

      </div>
    </div>

    <ul class="notif text-sm">
        @forelse ($notifs as $item)
      <li class="notif__item">
        <div class="padding-sm flex">
          <p><i class="font-semibold">{{ $item->data['type'] }}</i> на <a href="{{ $item->data['link'] }}#c{{ $item->data['id'] }}">странице</a>.</p>
            <div class="margin-left-auto">
                <form method="POST" action="{{ route('notifications.markNotification') }}">
                    @csrf
                    <input hidden type="text" name="id" value="{{ $item->id }}">
                    <button type="submit" class="btn btn--primary btn--sm">Прочитано</button>
                </form>
            </div>
        </div>
      </li>
      @empty
      <li>
          Нет новых уведомлений
      </li>
      @endforelse

    </ul>
  </div>
@endsection