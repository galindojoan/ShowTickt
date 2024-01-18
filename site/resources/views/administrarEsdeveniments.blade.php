@extends('layouts.master')

@section('title', 'resultados')

@section('content')
    <div class="event-cards">
        @foreach ($esdeveniments as $esdeveniment)
            <a href="{{ route('editar-esdeveniment', ['id' => $esdeveniment->id]) }}" class="event-link">
                <div class="event-card">
                    <div class="event-details">
                        <p>{{ $esdeveniment->nom }}  </p>
                        <p>{{ $esdeveniment->categoria->tipus}}</p>
                        <p>{{ $esdeveniment->recinte->lloc }}</p>
                    </div>
                    <img src="{{ Storage::url( $esdeveniment->imatge ) }}" alt="Imatge de l'esdeveniment">
                </div>
            </a>
        @endforeach
    </div>
    <div class="pages">{{ $esdeveniments->links('pagination::bootstrap-5') }}</div>
@endsection
