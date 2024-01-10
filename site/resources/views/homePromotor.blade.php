@extends('layouts.master')

@section('title', 'Login')

@section('content')

<div>
    @if(session('key'))
        <p>Bienvenido, {{ session('key') }}</p>
    @else
        <p>No has iniciado sesión</p>
    @endif
</div>
@endsection