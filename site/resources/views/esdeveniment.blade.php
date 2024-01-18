@extends('layouts.master')

@section('title', 'Detalles del Evento')

@section('content')
    <div class="containerEvent">
      {{-- {{$esdeveniment}} --}}
      <div class="textEvent">
        <h1>{{ $esdeveniment->nom }}</h1>
        <p>Lugar: {{ $esdeveniment->recinte->lloc }}</p>
        <form action="{{ route('confirmacioCompra') }}" method="post" class="ComprarEntrada" id="ComprarEntrada"
            enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <label for="fecha" class="form-label">Fecha</label>
              <select class="form-select" id="fecha" name="fecha" required>
                  @foreach ($fechas as $fecha)
                      <option value="{{ $fecha->id }}">{{ $fecha->data_sessio }}</option>
                  @endforeach
              </select>
          </div>
          <div class="form-group">
            <label for="preu" class="form-label">Tipus Entradas</label>
            <select class="form-select" id="preu" name="preu" required>
                @foreach ($entradas as $entrada)
                    <option value="{{ $entrada->id }}">{{$entrada->nom}} {{ $entrada->preu }}€ </option>
                @endforeach
            </select>
        </div>
          <div class="form-group">
            <label for="Preutotal" class="form-label">Total:{{$preuTotal}} </label>
        </div>
            <button tipe="submit">Comprar</button>
        </form>
        
      </div>
      <div class="imagenesEventos">
        <img src="{{ Storage::url( $esdeveniment->imatge ) }}" alt="Imatge de l'esdeveniment" class="event-imagen">
      </div>
      
    </div>
    
@endsection
