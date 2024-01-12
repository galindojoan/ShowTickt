@extends('layouts.master')

@section('title', 'Detalles del Evento')

@section('content')
    <div class="containerEvent">
      <div class="textEvent">
        <h1>{{ $esdeveniment->nom }}</h1>
        <p>Fecha: {{ $esdeveniment->dia }}</p>
        <p>Lugar: {{ $esdeveniment->recinte->lloc }}</p>
        <p>Precio: {{ $esdeveniment->preu }} €</p>
        <!-- Otros detalles del evento -->
      </div>
      <div class="imagenesEventos">
        <img id="imagenEvento"src="{{$esdeveniment->imatge}}">
      </div>
    </div>
    
@endsection
