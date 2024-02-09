<body>
    <div style="height: 100vh">
        <div class="titol-pdf">
            <img src="{{ asset('imagen/logo-definitivo.png') }}" alt="logoShowTickt" class="logo">
            <h1>ShowTickt</h1>
        </div>
        <h2>{{$event->nom}}</h2>
        <h5>{{$event->descripcio}}</h5>
        <h4>{{$event->sessio}}</h4>
        <h4>{{$event->lloc}}</h4>

    </div>
    @foreach ($entrades as $entrada)
        <div style="height: 100vh">
           <div id="Información">
                <h3>Entrada: {{$entrada->nom}}</h3>
                @if ($entrada->nominal)
                    <h5>Nombre Asistente: {{$entrada->asistenteNom}}</h5>
                @else
                    <h5>Nombre Comprador: {{$entrada->compradorNom}}</h5>
                @endif
                <p>DNI/NIE: {{$entrada->clientNie}}</p>
                <p>Precio: {{$entrada->preu}}€</p>
           </div>
           <div id="codi-qr">
                <h3>Codigo QR:</h3>
                {{QrCode::size(300)->generate($entrada->numerIdentificador)}}
                <h3>Numero Identificador de la entrada: </h3>
                <p>{{$entrada->numerIdentificador}}</p>
           </div>
        </div> 
    @endforeach
</body>