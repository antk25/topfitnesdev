@extends('layouts.base')
{{-- Переопределяем секцию content от базового шаблона --}}
@section('content')

@livewire('selection')

@endsection
@section('footerScripts')