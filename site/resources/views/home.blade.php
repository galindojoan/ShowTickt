@extends('layouts.master')

@section('title', 'Home')

@section('content')
    @if ($events->isEmpty())
        <div class="center-message">
            <p class="info-alert">No se ha encontrado ningún evento.</p>
        </div>
    @else
        <div class="container">
            <form action="{{ route('cerca') }}" method="get" class="form" id="filtre">
                <div class="input-group">
                    <select name="category" class="form-control" onchange="this.form.submit()">
                        <option value="" disabled selected>Categorías</option>
                        <option value="" {{ $categoryId === null ? 'selected' : '' }}>Mostrar todos</option>
                        @foreach ($categoriesWithEventCount as $category)
                            <option value="{{ $category->id }}" {{ $categoryId == $category->id ? 'selected' : '' }}>
                                {{ $category->tipus }} ({{ $category->eventCount }} eventos)
                            </option>
                        @endforeach
                    </select>
                    <div class="icon-container">
                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14"
                            viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                            <path
                                d="M201.4 342.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 274.7 86.6 137.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z" />
                        </svg>
                    </div>
                </div>
            </form>



            <!-- Formulario de búsqueda -->
            <form action="{{ route('cerca') }}" method="get" class="form" id="cerca">
                <div class="input-group">
                    <!-- Campo de entrada oculto para la categoría -->
                    <input type="hidden" name="category" value="{{ $categoryId }}">
                    <input type="text" name="q" class="form-control" placeholder="Buscar">
                    <button type="submit" class="btn-primary"><svg xmlns="http://www.w3.org/2000/svg" height="16"
                            width="16"
                            viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                            <path fill="#1e91d9"
                                d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" />
                        </svg></button>
                </div>
            </form>
            <form id="promotores" method="POST"
                action="@if (session('key')) {{ route('homePromotor') }}
            @else{{ route('login') }} @endif">
                @csrf
                <input class="linkPromotor" type="submit" value="PROMOTORES">
            </form>
        </div>



        @foreach ($categoriesWith3 as $category)
            <div class="event-home">
                <h2>{{ $category->tipus }}</h2>
                @php
                    $cont = 0;
                @endphp
                @foreach ($esdeveniments as $esdeveniment)
                    @if ($esdeveniment->categoria_id == $category->id && $cont < 3)
                        @php
                            $cont++;
                        @endphp
                        <a href="{{ route('mostrar-esdeveniment', ['id' => $esdeveniment->id]) }}" class="event-link">
                            <div class="event-card">
                                <div class="event-details">
                                    <p>{{ $esdeveniment->nom }}</p>
                                    @if ($esdeveniment->sesions->isNotEmpty() && $esdeveniment->sesions->first()->data !== null)
                                        <p>{{ $esdeveniment->sesions->first()->data }}</p>
                                    @else
                                    <p>No hay sesiones</p>
                                    @endif
                                        <p>{{ $esdeveniment->recinte->lloc }}</p>
                                        @if ($esdeveniment->sesions->isNotEmpty() && $esdeveniment->sesions->first()->entrades->isNotEmpty())
                                            <p>{{ $esdeveniment->sesions->first()->entrades->first()->preu }} €</p>
                                        @else
                                        <p>Entradas Agotadas</p>
                                        @endif
                                </div>
                                <img src="{{ Storage::url($esdeveniment->imatge) }}" alt="Imatge de l'esdeveniment">
                            </div>
                        </a>
                    @endif
                @endforeach

                <form action="{{ route('cerca') }}" method="get" class="event-form">
                    <div class="event-group">
                        <input type="hidden" name="category" value="{{ $category->id }}">
                        <button type="submit" class="event-btn">ver mas ></button>
                    </div>
                </form>

            </div>
        @endforeach
    @endif

    {{-- <div class="pages">{{ $esdeveniments->links('pagination::bootstrap-5') }}</div> --}}
@endsection
