@extends('layouts.master')

@section('title', 'Home')

@section('content')

        <div class="bg">
            @if (session('key'))
                <div class="button-container">
                    <a href="{{ route('administrar-esdeveniments') }}" class="custom-button">Administrar Eventos</a>
                    <a href="{{ route('llistat-sessions' )}}" class="custom-button">Listado de sesiones</a>
                    <a href="{{ route('crear-esdeveniment') }}" class="custom-button">Crear Evento</a>
                </div>
            @endif
        </div>
@endsection
