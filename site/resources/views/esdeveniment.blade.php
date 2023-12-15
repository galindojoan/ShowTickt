@extends('layouts.master')

@section('title', 'Detalles del Evento')

@section('content')
    <div class="container">
        <h1>{{ $esdeveniment->nom }}</h1>
        <p>Fecha: {{ $esdeveniment->dia }}</p>
        <p>Lugar: {{ $esdeveniment->recinte->lloc }}</p>
        <p>Precio: {{ $esdeveniment->preu }} €</p>
        <!-- Otros detalles del evento -->
    </div>
@endsection
