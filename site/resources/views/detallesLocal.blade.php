@extends('layouts.master')

@section('title', 'local')

@section('content')
    <div class="containerEvent">
        <div class="textEvent">
            <h1>{{ $esdeveniment->nom }}</h1>
            <p><strong>Provincia:</strong>{{ $esdeveniment->provincia }}</p>
            <p><strong>Lugar:</strong>{{ $esdeveniment->lloc }}</p>
        </div>

    </div>
    <div class="mapaLocal">
      <x-maps-leaflet :centerPoint="['lat' => 52.16, 'long' => 5]" class="event-imagen"></x-maps-leaflet>
    </div>

@endsection
