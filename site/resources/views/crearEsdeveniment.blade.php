@extends('layouts.master')

@section('title', 'crear')

@section('content')
    <div>
        @if (session('key'))
            <p>Bienvenido, {{ session('key') }}</p>
        @endif
        @if (session('user_id'))
            <p>Bienvenido, Usuario ID: {{ session('user_id') }}</p>
        @endif

        <form action="{{ route('crear-esdeveniment.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="user_id" id="user_id" value="{{ session('user_id') }}">

            <div class="mb-3">
                <label for="titol" class="form-label">Título del evento</label>
                <input type="text" class="form-control" id="titol" name="titol" required>
            </div>

            <div class="mb-3">
                <label for="categoria" class="form-label">Categoría</label>
                <select class="form-select" id="categoria" name="categoria" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->tipus }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="recinte" class="form-label">Recinte</label>
                <select class="form-select" id="recinte" name="recinte" required>
                    @foreach ($recintes as $recinte)
                        <option value="{{ $recinte->id }}">{{ $recinte->nom }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="imatge" class="form-label">Imagen principal del evento</label>
                <input type="file" class="form-control" id="imatge" name="imatge" accept="image/*" required>
            </div>

            <div class="mb-3">
                <label for="descripcio" class="form-label">Descripción del evento</label>
                <textarea class="form-control" id="descripcio" name="descripcio" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="data_hora" class="form-label">Fecha y hora de la celebración</label>
                <input type="datetime-local" class="form-control" id="data_hora" name="data_hora" required>
            </div>

            <div class="mb-3">
                <label for="aforament_maxim" class="form-label">Aforo máximo</label>
                <input type="number" class="form-control" id="aforament_maxim" name="aforament_maxim" required>
            </div>

            <button type="submit" class="btn btn-primary">Crear Esdeveniment</button>
        </form>
    </div>
@endsection
