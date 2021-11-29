@extends('layouts.base')
{{-- Переопределяем секцию content от базового шаблона --}}
@section('content')

@livewire('bracelets')

@endsection

@section('footerScripts')