<body>
    <div style="height: 100vh">
        <h1>{{$event->nom}}</h1>
        <h5>{{$event->descripcio}}</h5>
        <h4>{{$event->sessio}}</h4>
        <h4>{{$event->lloc}}</h4>

    </div>
    @foreach ($entrades as $entrada)
        <div style="min-height: 100vh">
           <div id="Información">
                <h3>Entrada: {{$entrada->nom}}</h3>
                <h5>Nombre: {{$entrada->clientNom}}</h5>
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