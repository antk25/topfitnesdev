<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>document.getElementsByTagName("html")[0].className += " js";</script>
    <link rel="stylesheet" href="{{ asset('css/admin/style.css') }}">
    <title>@yield('title')</title>
</head>
<body class="bg-contrast-lower min-height-100vh flex flex-center padding-md">

@section('content')
@show

@section('footerScripts')
    <script src="{{ asset("js/scripts.js") }}"></script>
@show


</body>
</html>
