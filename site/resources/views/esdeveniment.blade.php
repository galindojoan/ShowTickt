@extends('layouts.master')

@section('title', 'Detalles del Evento')

@section('content')
    <div class="containerEvent">
        {{-- {{$esdeveniment}} --}}
        <div class="textEvent">
            <h1>{{ $esdeveniment->nom }}</h1>
            <h6>{{ $esdeveniment->descripcio }}</h6>
            <form action="{{ route('detallesLocal', ['id' => $esdeveniment->id]) }}" method="get" class="detallesLocal"
                id="detallesLocal">
                <p><strong>Local:</strong> {{ $esdeveniment->recinte->lloc }}<button tipe="submit">Ver Local</button></p>
            </form>

            <form action="{{ route('confirmacioCompra') }}" method="post" class="ComprarEntrada" id="ComprarEntrada"
                enctype="multipart/form-data"name="a">
                @csrf
                <div class="form-group">
                    <label for="fecha" class="form-label">Sesiones:</label>
                    <select class="form-select" id="fecha" name="fecha" required>
                      <option value="" disabled selected>Fechas de las sesiones</option>
                        @foreach ($fechas as $fecha)
                            <option value="{{ $fecha->data_sessio }}">{{ $fecha->data_sessio }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" id="entradas" style="display:none;">
                  <label for="preu" class="form-label">Tipus Entradas:</label>
                  <select class="form-select" id="preu" name="preu" required>
                    <option value="" disabled selected>Entradas</option>
                      @foreach ($entradas as $entrada)
                          <option value="{{ $entrada->preu }},{{$entrada->quantitat}},{{$entrada->nom}}" >{{ $entrada->nom }} {{ $entrada->preu }}€ </option>
                      @endforeach
                  </select>
                  <label for="cantidad" class="form-label" id="escogerCantidad">Escoge el numero de entradas:</label>
                  
                  <div class="form-group" id="errorCantidad" style="display:none;">
                    <p id="mensajeError" class="errorMsg"></p>
                  </div>
                  <input type="number" id="cantidad" name="cantidad" min="1" max="2" />
                  <button type="button" id="reservarEntrada">Reservar entrada</button>
                 
                  <div class="form-group" id="listaEntradas" style="display:none;">
                    <label for="cantidad" class="form-label">Entradas Reservadas:</label>
                    <div id="containerList">
                      
                    </div>
                    <button type="button" id="eliminarReserva" class="event-list">Eliminar reserva</button>
                  </div>

              </div>
                <div class="form-group">
                    <label for="Preutotal" class="form-label"id="precioTotal">Total:{{ $preuTotal }} </label>
                </div>
                <button type="submit">Comprar</button>
            </form>

        </div>
        <div class="imagenesEventos">
            <img src="{{ Storage::url($esdeveniment->imatge) }}" alt="Imatge de l'esdeveniment" class="event-imagen">
        </div>

    </div>
@endsection

@section('scripts')
<script src="{{ asset('js/esdeveniment.js') }}"></script>
@endsection