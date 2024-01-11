@extends('layouts.master')

@section('title', 'Login')

@section('content')

<div>
    @if(session('key'))
        <p>Bienvenido, {{ session('key') }}</p>
        <div class="button-container">
            <a href="{{ route('crear-esdeveniment') }}" class="custom-button">Crear Esdeveniment</a>
        </div>
    @endif
</div>
@endsection