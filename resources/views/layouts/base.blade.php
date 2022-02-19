<!DOCTYPE html>
<html lang="ru">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>document.getElementsByTagName("html")[0].className += " js";</script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <livewire:styles />
    @stack('css')
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')" />

</head>
<body>
    @section('header')
      @include('layouts.parts.header')

      @show

    @section('content')
    @show

@include('layouts.parts.footer')

{{--  Back to Top  --}}
    <a class="back-to-top js-back-to-top" href="#" data-offset="100" data-duration="300">
        <svg class="icon" viewBox="0 0 20 20"><polyline points="2 13 10 5 18 13" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
    </a>
{{--  End Back to Top  --}}
 <script src="{{ asset("js/scripts.js") }}"></script>
 <livewire:scripts />
@stack('js')
      </body>
      </html>
