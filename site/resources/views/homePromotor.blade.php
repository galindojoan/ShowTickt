@extends('layouts.master')

@section('title', 'Home')

@section('content')

        <div class="bg">
            @if (session('key'))
                <div class="button-container">
                    <a href="{{ route('administrar-esdeveniments') }}" class="custom-button">Administrar Esdeveniments</a>
                    <a href="{{ route('llistat-sessions' )}}" class="custom-button">Llistat de sessions</a>
                    <a href="{{ route('crear-esdeveniment') }}" class="custom-button">Crear Esdeveniment</a>
                </div>
            @endif
        </div>
@endsection
