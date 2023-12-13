@extends('layouts.master')

@section('title', 'Home')

@section('content')

@section('content')
    <div class="container">
        <h1>Eventos</h1>

        <div class="event-cards">
            @foreach ($esdeveniments as $esdeveniment)
                <div class="event-card">
                    <div class="event-details">
                        <p>{{ $esdeveniment->nom }}</p>
                        <p>{{ $esdeveniment->dia }}</p>
                        <p>{{ $esdeveniment->recinte->lloc }}</p>
                        <p>{{ $esdeveniment->preu }} €</p>
                    </div>
                    <img src="{{ $esdeveniment->imatge }}" alt="Imatge de l'esdeveniment">
                </div>
            @endforeach
        </div>

        {{ $esdeveniments->links() }}
    </div>
@endsection
