@extends('layouts.master')

@section('title', 'resultados')

@section('content')
    @if ($esdeveniments->isEmpty())
        <div class="center-message">
            <p class="info-alert">No se ha encontrado ningún evento.</p>
        </div>
    @else
        <div class="info-message">
            <p class="info-text">Haz clic sobre un evento para poder editarlo.</p>
        </div>

        <div class="event-cards">
            @foreach ($esdeveniments as $esdeveniment)
                <a href="{{ route('editar-esdeveniment', ['id' => $esdeveniment->id]) }}" class="event-link">
                    <div class="event-card">
                        <div class="event-details">
                            <h1>{{ $esdeveniment->nom }} </h1>
                            @if ($esdeveniment->sesions->isNotEmpty() && $esdeveniment->sesions->first()->data !== null)
                                <h3>{{ $esdeveniment->sesions->first()->data }}</h3>
                            @else
                                <h3>No hay sesiones</h3>
                            @endif
                            <h4>{{ $esdeveniment->recinte->lloc }}</h4>
                            @if ($esdeveniment->sesions->isNotEmpty() && $esdeveniment->sesions->first()->entrades->isNotEmpty())
                                <h2>{{ $esdeveniment->sesions->first()->entrades->first()->preu }} €</h2>
                            @else
                                <h2>Sin entradas</h2>
                            @endif
                        </div>
                        <img src="{{ Storage::url($esdeveniment->imatge) }}" alt="Imatge de l'esdeveniment">
                    </div>
                </a>
            @endforeach
        </div>
        <div class="pages">{{ $esdeveniments->links('pagination::bootstrap-5') }}</div>
    @endif
@endsection
