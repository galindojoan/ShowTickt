@extends('layouts.master')

@section('title', 'Confirmar compra')

@section('content')
    <h1>{{ $nomEvent }}</h1>
    {{$sessionArray}}
    <h5>Resumen De la Compra:</h5>
    <div id="resumenCompra">
        <p id="fecha">Fecha:</p>
        <p id="hora">Horas:</p>
        <div id="resumPrecio" class="ticketCompra">
            <p>Nombre</p>
            <p>cantidad</p>
            <p>Precio</p>
            <p>Total</p>
        </div>
        {{-- @foreach ($sessionArray as $session) --}}
            @foreach ($entradaArray as $entrada)
                <div class="ticketCompra">
                    <p>{{ $entrada->nom }}</p>
                    <p>{{ $entrada->cantidad }}</p>
                    <p>{{ $entrada->precio }}€</p>
                    <p>{{ $entrada->precio * $entrada->cantidad }}€</p>
                </div>
            @endforeach
        {{-- @endforeach --}}
    </div>
    <p id="hora">Total: {{ $total }}€</p>
    </div>
    <form action="{{ route('confirmacioCompra') }}" method="post" class="ComprarEntrada" id="ComprarEntrada">
        @if (1 == 2)
            <div class="form-group">
                <label for="nova_carrer" class="form-label">Nombre de la calle</label>
                <input type="text" class="form-controller" id="nova_carrer" name="nova_carrer"
                    value="{{ old('nova_carrer') }}">
                <div id="errorDivcarrer" class="errorDiv" style="display: none;">
                    <div id="errorContent">
                        <div class="error-message" id="error-carrer"></div>
                    </div>
                </div>
            </div>
        @else
            <div class="form-group">
                <label for="nova_carrer" class="form-label">Nombre de la calle</label>
                <input type="text" class="form-controller" id="nova_carrer" name="nova_carrer"
                    value="{{ old('nova_carrer') }}">
                <div id="errorDivcarrer" class="errorDiv" style="display: none;">
                    <div id="errorContent">
                        <div class="error-message" id="error-carrer"></div>
                    </div>
                </div>
            </div>
        @endif
        <div class="form-group">
          <label for="email" class="form-label">Mail:</label>
          <input type="email" class="form-controller" id="email" name="email">
      </div>
      
        <button type="submit" id="bottonCompra">Finalizar Compra</button>
    </form>
    {{-- <form action="{{ route('mostrar-esdeveniment', ['id' => $sessionArray->esdeveniments_id]) }}" id="vueltaAtras">

    </form> --}}
@endsection
@section('scripts')
    <script>
        const verFecha = document.getElementById("fecha");
        const verHora = document.getElementById("hora");
        const sessionArray = @json($sessionArray);
        const entradaArray = @json($entradaArray);

        setTimeout(function () {
                document.getElementById("vueltaAtras").submit();
            }, (10 * 60 * 1000));

        function pad(numero) {
            return numero < 10 ? "0" + numero : numero;
        }

        function fecha(fechaHoraString) {
            const fechas = new Date(fechaHoraString);
            const año = fechas.getFullYear();
            const mes = pad(fechas.getMonth() + 1);
            const dia = pad(fechas.getDate());
            return `${año}/${mes}/${dia}`;
        }

        function hora(fechaHoraString) {
            const Horas = new Date(fechaHoraString);
            const hora = pad(Horas.getHours() - 5);
            const minuto = pad(Horas.getMinutes());
            return `${hora}:${minuto}`;
        }
        verFecha.textContent = `Fecha: ${fecha(sessionArray[0].data)}`;
        verHora.textContent = `Hora: ${hora(sessionArray[0].data)}`;

    </script>
@endsection
