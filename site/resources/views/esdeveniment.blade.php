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
                <p><strong>Local:</strong> {{ $esdeveniment->recinte->lloc }}<button type="submit">Ver Local</button></p>
            </form>

            <form action="{{ route('confirmacioCompra') }}" method="post" class="ComprarEntrada" id="ComprarEntrada"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="detallesEvents" name='detallesEvents' value='{{$esdeveniment}}'>
                <label for="session" class="form-label">Sesiones:</label>
                @if (count($fechas) == 1)
                    <div class="form-group">

                        @foreach ($fechas as $fecha)
                            <p>{{ $fecha->data }}</p>
                        @endforeach
                        @php
                        $fechaSola=true;
                        @endphp
                    </div>
                @else
                    <div id="calendar"></div>
                @endif

                <div class="form-group" id="entradas" style="display:none;">
                    <label id="preu" class="form-label">Tipus Entradas:</label>
                    {{-- @if (count($entradas)==1)
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
                        <select class="form-select" id="{{ $fecha->id }}" name="preu" style="display:none;">
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
                    

                    <label for="cantidad" class="form-label" id="escogerCantidad">Escoge el Ticket y la cantidad:</label>
                    <div class="form-group" id="errorCantidad" style="display:none;">
                        <p id="mensajeError" class="msg-error"></p>
                    </div>
                    <input type="number" id="cantidad" name="cantidad" min="1" max="10" value="2" />
                    <button type="button" id="reservarEntrada">Añadir Tickets</button>

                    <div class="form-group" id="listaEntradas" style="display:none;">
                        <label for="cantidad" class="form-label">Lista de Tickets:</label>
                        <div id="containerList">

                        </div>
                    </div>
                    <div class="form-group">
                      <p id="precioTotal" class="form-label">Total: 0€ </p>
                  </div>
                  <input type="hidden" id="arrayEntradas" class='arrayEntradas'>
                  <input type="hidden" id="inputTotal" name='inputTotal'>
                  <button type="submit" id="bottonCompra">Confirmar Compra</button>
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
        const fechaSola=@json($fechaSola);
        // Ordenar el array utilizando la función de comparación
        fechasSessiones.sort(compararFechas);
        if(fechaSola){
          sessionSelect(fechasSessiones[0]);
          console.log(1);
        }else{
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
                    sessionSelect(fechasSessiones[(parseInt(sessionId[0]) - 1)]);
                }
            });
            calendar.render();
        });
        }
        
    </script>
@endsection
