@extends('layouts.master')

@section('title', 'Home')

@section('content')
    <div class="container">

        <form action="{{ route('cerca') }}" method="get" class="form" id="filtre">
            <div class="input-group">
                <select name="category" class="form-control" onchange="this.form.submit()">
                    <option value="" {{ empty($categoryId) ? 'selected' : '' }}>Todas las categorías</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->tipus }}</option>
                    @endforeach
                </select>
            </div>
        </form>
        

        <!-- Formulario de búsqueda -->
        <form action="{{ route('cerca') }}" method="get" class="form" id="cerca">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Buscar">
                <button type="submit" class="btn-primary"><svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path fill="#1e91d9" d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg></button>
            </div>
        </form>

        

        {{ $esdeveniments->links('pagination::bootstrap-5') }}
    </div>
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
@endsection
