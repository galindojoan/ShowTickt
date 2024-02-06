@extends('layouts.master')

@section('title', 'Detalles del Evento')
@section('metadades','Mira los detalles sobre el evento {{$esdeveniment->nom}} y adquiere sus entradas.')
@section('metaimages','{{$esdeveniment->imatge}}')

@section('content')
    <div class="containerEvent">
        {{-- {{$esdeveniment}} --}}
        <div class="infoEvent">
            <h1>{{ $esdeveniment->nom }}</h1>
            <h4>{{ $esdeveniment->descripcio }}</h4>
        </div>
        <div class="textEvent">
            <form action="{{ route('detallesLocal', ['id' => $esdeveniment->id]) }}" method="get" class="detallesLocal"
                id="detallesLocal">
                <p><strong>Local:</strong> {{ $esdeveniment->recinte->lloc }}</p>
                <button type="submit" class="btn btn-blue">Ver Local</button>
            </form>

            <form action="{{ route('confirmacioCompra') }}" method="post" class="ComprarEntrada" id="ComprarEntrada"
                enctype="multipart/form-data" style="justify-self: normal">
                @csrf
                <input type="hidden" id="detallesEvents" name='detallesEvents' value='{{$esdeveniment->nom}}'>
                <div class="inlineDiv">
                  <label for="session" class="form-label" id="fechaSesion"><strong>Sesiones:</strong></label>
                  <button id="buttonSesion" class="btn btn-blue" style="display: none;">Cambiar sesión</button>
              </div>
                @if (count($fechas) == 1)
                    <div class="form-group">

                        @foreach ($fechas as $fecha)
                            <p>{{ $fecha->data }}</p>
                        @endforeach
                        @php
                            $fechaSola = true;
                        @endphp
                    </div>
                @else
                    <div id="calendar"></div>
                @endif

                <div class="form-group" id="entradas" style="display:none;">
                    <label id="preu" class="form-label">Escoge el tipo de entrada:</label>
                    {{-- @if (count($entradas) == 1)
                    @foreach ($fechas as $fecha)
                        <select class="form-select" id="{{ $fecha->id }}" name="preu" style="display:none;">
                            <option value="" disabled selected>Entradas</option>
                            @foreach ($entradas as $entrada)
                                @if ($entrada->sessios_id == $fecha->id)
                                    <label
                                        value="{{ $entrada->preu }},{{ $entrada->quantitat }},{{ $entrada->nom }},{{ $entrada->id }}">
                                        {{ $entrada->nom }} {{ $entrada->preu }}€ </label>
                                @endif
                            @endforeach
                        </select>
                    @endforeach
                    @else --}}
                    @foreach ($fechas as $fecha)
                        <select class="form-select" id="{{ $fecha->id }}" name="preu"
                            style="display:none; margin-bottom:15%;">
                            <option value="" disabled selected>Entradas</option>
                            @foreach ($entradas as $entrada)
                                @if ($entrada->sessios_id == $fecha->id)
                                    <option
                                        value="{{ $entrada->preu }},{{ $entrada->quantitat }},{{ $entrada->nom }},{{ $entrada->id }}">
                                        {{ $entrada->nom }} {{ $entrada->preu }}€ </option>
                                @endif
                            @endforeach
                        </select>
                    @endforeach
                    {{-- @endif --}}


                    <label for="cantidad" class="form-label" id="escogerCantidad">Escoge la cantidad:</label>
                    <div class="form-group" id="errorCantidad" style="display:none;">
                        <p id="mensajeError" class="msg-error"></p>
                    </div>
                    <div style="margin-bottom: 8%">
                        <input type="number" id="cantidad" name="cantidad" min="1" max="10" value="2" />
                        <button type="button" id="reservarEntrada" class="btn btn-blue">Añadir Tickets</button>
                    </div>

                    <div class="form-group" id="listaEntradas" style="display:none;">
                        <label for="cantidad" class="form-label">Lista de Tickets:</label>
                        <div id="containerList">

                        </div>
                    </div>
                  <div class="form-group inlineDiv">
                    <p id="precioTotal" class="form-label">Total: 0€ </p>
                    <input type="hidden" id="arrayEntradas" name='arrayEntradas'>
                    <input type="hidden" id="inputTotal" name='inputTotal'>
                    <button type="submit" id="bottonCompra" class="btn btn-orange">Realizar Compra</button>
                </div>
                </div>
            </form>

        </div>
        <div class="imagenesEventos">
            <img src="{{ Storage::url($esdeveniment->imatge) }}" alt="Imatge de l'esdeveniment" class="event-imagen">
        </div>

    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/esdeveniment.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script>
        const fechasSessiones = @json($fechas);
        const entradaPrecio = @json($entradas);
        const fechaSola = @json($fechaSola);
        // Ordenar el array utilizando la función de comparación
        fechasSessiones.sort(compararFechas);
        if (fechaSola) {
            sessionSelect(fechasSessiones[0]);
            console.log(1);
        } else {
            document.addEventListener('DOMContentLoaded', function() {
                let buenas;
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next',
                        center: 'title',
                        right: 'dayGridMonth,dayGridWeek'
                    },
                    selectable: true,
                    events: crearEventos(fechasSessiones),
                    eventClick: function(event) {
                        let sessionId = event.event.title.split(" ");
                        document.getElementById('calendar').style.display = 'none';
                        document.getElementById('fechaSesion').innerHTML =
                            `<strong>Sesion:</strong> ${fechasSessiones[(parseInt(sessionId[0]) - 1)].data}`;
                        document.getElementById('buttonSesion').style.display = 'block';
                        sessionSelect(fechasSessiones[(parseInt(sessionId[0]) - 1)]);

                    }
                });
                calendar.render();
            });
            document.getElementById('buttonSesion').addEventListener('click',function (e) {
                e.preventDefault();
                document.getElementById('calendar').style.display = 'block';
                document.getElementById('fechaSesion').innerHTML =
                    `Sesiones:`;
                document.getElementById('buttonSesion').style.display = 'none';
            })
        }
    </script>
@endsection
