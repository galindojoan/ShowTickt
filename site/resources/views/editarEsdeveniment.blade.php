@extends('layouts.master')

@section('title', 'Editar Evento')

@section('content')
    <div class="containerEvent">
        <div class="textEvent">
            <h1>{{ $esdeveniment->nom }}</h1>
            <p>Fecha: {{ $esdeveniment->dia }}</p>
            <p>Lugar: {{ $esdeveniment->recinte->lloc }}</p>
            <!-- Otros detalles del evento -->
        </div>
        <div class="imagenesEventos">
            <img id="imagenEvento" src="{{ asset($esdeveniment->imatge) }}" alt="Imatge de l'esdeveniment">
        </div>
    </div>

@endsection
