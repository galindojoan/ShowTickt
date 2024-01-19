@extends('layouts.master')

@section('title', 'resultados')

@section('content')
    <div class="event-cards">
        @foreach ($esdeveniments as $esdeveniment)
            <a href="{{ route('editar-esdeveniment', ['id' => $esdeveniment->id]) }}" class="event-link">
                <div class="event-card">
                    <div class="event-details">
                        <p>{{ $esdeveniment->nom }} </p>
                        @if ($esdeveniment->sesions->isNotEmpty() && $esdeveniment->sesions->first()->data !== null)
                            <p>{{ $esdeveniment->sesions->first()->data }}</p>
                        @else
                            <p>No hay sesiones</p>
                        @endif
                        <p>{{ $esdeveniment->recinte->lloc }}</p>
                        @if ($esdeveniment->sesions->isNotEmpty() && $esdeveniment->sesions->first()->entrades->isNotEmpty())
                            <p>{{ $esdeveniment->sesions->first()->entrades->first()->preu }} €</p>
                        @else
                            <p>Sin entradas</p>
                        @endif
                    </div>
                    <img src="{{ Storage::url($esdeveniment->imatge) }}" alt="Imatge de l'esdeveniment">
                </div>
            </a>
        @endforeach
    </div>
    <div class="pages">{{ $esdeveniments->links('pagination::bootstrap-5') }}</div>
@endsection
