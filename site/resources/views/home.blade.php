@extends('layouts.master')

@section('title', 'Home')

@section('content')

<h1>Llista de Esdeveniments</h1>

@foreach ($esdeveniments as $esdeveniment)
    <div>
        <h2>{{ $esdeveniment->nom }}</h2>
        <img src="{{ $esdeveniment->imatge }}" alt="Imatge de l'esdeveniment">
        <p>Data de l’esdeveniment: {{ $esdeveniment->dia }}</p>
        <p>Lloc: {{ $esdeveniment->recinte->lloc }}</p>
        <p>Menor preu de les sessions: {{ $esdeveniment->preu }} €</p>
    </div>
@endforeach
    

@endsection