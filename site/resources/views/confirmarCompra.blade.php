@extends('layouts.master')

@section('title', 'Confirmar compra')

@section('content')
    <div id="content-container">
        <center>
            <h1>Resumen de la compra:</h1>
        </center>
        <div class="resumenCompra">
            <h3>Evento: {{ $nomEvent }}</h3>
            <p id="fecha">Fecha:</p>
            <p id="hora">Horas:</p>
            <div class="ticket-tabla">
                <div class="ticket-compra" style="background-color: rgb(228, 228, 228)">
                    <p>Nombre</p>
                    <p>cantidad</p>
                    <p>Precio</p>
                    <p>Total</p>
                </div>
                @foreach ($entradaArray as $entrada)
                    <div class="ticket-compra">
                        <p>{{ $entrada->nom }}</p>
                        <p>{{ $entrada->cantidad }}</p>
                        <p>{{ $entrada->precio }}€</p>
                        <p>{{ $entrada->precio * $entrada->cantidad }}€</p>
                    </div>
                @endforeach
            </div>
            <p id="total">Total: {{ $total }}€</p>
        </div>
        <form action="{{ route('procesCompra') }}" method="post" class="ticket-datos" id="ComprarEntrada">
          @csrf
          <input type="hidden" name="total" value="{{$total}}">
            @if ($sessionArray->nominal == true)
                @foreach ($entradaArray as $entrada)
                    <h3>{{ $entrada->nom }}</h3>
                    @for ($i = 1; $i <= $entrada->cantidad; $i++)
                        <div class="errorDiv" id="error" style="display:none;">
                            <p id="mensajeError" class="msg-error"></p>
                        </div>
                        <div class="form-group" id="divNominal">
                            <label for="nova_carrer" class="form-label">Nom</label>
                            <input type="text" class="form-controller" id="NomComprador" name="NomComprador"
                                maxlength="50">
                            <label for="nova_carrer" class="form-label">DNI/NIE</label>
                            <input type="text" class="form-controller" id="DNIComprador" name="DNIComprador" maxlength="9">
                            <label for="nova_carrer" class="form-label">Numero de Telefono</label>
                            <input type="tel" pattern="[0-9]{10}" class="form-controller" id="telefonComprador"
                                name="telefonComprador" maxlength="9" required>
                        </div>
                        <br>
                    @endfor
                @endforeach
            @else
                <div class="errorDiv" id="error" style="display:none;">
                    <p id="mensajeError"></p>
                </div>
                <div class="form-group">
                    <label for="nova_carrer" class="form-label">Nom</label>
                    <input type="text" class="form-controller" id="NomComprador" name="NomComprador" maxlength="50">
                    <label for="nova_carrer" class="form-label">DNI/NIE</label>
                    <input type="text" class="form-controller" id="DNIComprador" name="DNIComprador" maxlength="9">
                    <label for="nova_carrer" class="form-label">Numero de Telefono</label>
                    <input type="tel" class="form-controller" pattern="[0-9]{10}" maxlength="9" id="telefonComprador"
                        name="telefonComprador">
                </div>
            @endif

            <div class="form-group" style="margin-top: 5%;">
                <label for="email" class="form-label">Mail</label>
                <input type="email" class="form-controller" id="email" name="email">
            </div>
            <button type="button" id="bottonCompra" class="btn btn-blue" style="height: 32px;">Finalizar Compra</button>
        </form>
    </div>

    <form action="{{ route('mostrar-esdeveniment', ['id' => $sessionArray->esdeveniments_id]) }}" id="vueltaAtras">
      @csrf
    </form>
@endsection
@section('scripts')
    <script>
        let esError = true;
        const verFecha = document.getElementById("fecha");
        const verHora = document.getElementById("hora");
        const MasAsistents = document.getElementById("añadirAsistente");
        const divNominal = document.getElementById("divNominal");
        const divError = document.getElementById("error");
        const mensajeError = document.getElementById("mensajeError");
        const comprar = document.getElementById("bottonCompra");
        const sessionArray = @json($sessionArray);
        const entradaArray = @json($entradaArray);

        function mirarTodosLosErrores() {
            if (document.querySelectorAll(".ticket-error").length > 0) {
                document.querySelectorAll(".ticket-error").forEach(element => {
                    element.remove();
                });
            }
            const nombre = document.querySelectorAll("#NomComprador");
            const dni = document.querySelectorAll("#DNIComprador");
            const telefono = document.querySelectorAll("#telefonComprador");

            nombre.forEach(element => {
                if (element.value) {
                    if (element.value.length > 50) {
                        const DivEntrada = document.createElement("div");
                        DivEntrada.classList.add("ticket-error");
                        element.insertAdjacentElement("beforebegin", DivEntrada);
                        let entradaP = document.createElement("p");
                        entradaP.textContent = `El Nombre tiene mas caracter de lo permitido`;
                        DivEntrada.appendChild(entradaP);
                    }
                } else {
                    const DivEntrada = document.createElement("div");
                    DivEntrada.classList.add("ticket-error");
                    element.insertAdjacentElement("beforebegin", DivEntrada);
                    let entradaP = document.createElement("p");
                    entradaP.textContent = `El Nombre no puede estar vacio`;
                    DivEntrada.appendChild(entradaP);
                }

            });
            dni.forEach(element => {
                if (element.value) {
                    if ((element.value.length < 9)) {
                        const DivEntrada = document.createElement("div");
                        DivEntrada.classList.add("ticket-error");
                        element.insertAdjacentElement("beforebegin", DivEntrada);
                        let entradaP = document.createElement("p");
                        entradaP.textContent = `El DNI tiene Menos caracter de lo permitido`;
                        DivEntrada.appendChild(entradaP);
                    } else if (element.value.length > 9) {
                        const DivEntrada = document.createElement("div");
                        DivEntrada.classList.add("ticket-error");
                        element.insertAdjacentElement("beforebegin", DivEntrada);
                        let entradaP = document.createElement("p");
                        entradaP.textContent = `El DNI tiene mas caracter de lo permitido`;
                        DivEntrada.appendChild(entradaP);
                    }else if(!/^\d{8}[A-Za-z]$/.test(element.value) && !/^[XYZ]\d{7,8}[A-Z]$/.test(element.value)){
                      const DivEntrada = document.createElement("div");
                        DivEntrada.classList.add("ticket-error");
                        element.insertAdjacentElement("beforebegin", DivEntrada);
                        let entradaP = document.createElement("p");
                        entradaP.textContent = `El DNI/NIE no tiene el formato correcto`;
                        DivEntrada.appendChild(entradaP);
                    }
                } else {
                    const DivEntrada = document.createElement("div");
                    DivEntrada.classList.add("ticket-error");
                    element.insertAdjacentElement("beforebegin", DivEntrada);
                    let entradaP = document.createElement("p");
                    entradaP.textContent = `El DNI no puede estar vacio`;
                    DivEntrada.appendChild(entradaP);
                }
            });
            telefono.forEach(element => {
                if (element.value) {
                    if (element.value.length >9) {
                        const DivEntrada = document.createElement("div");
                        DivEntrada.classList.add("ticket-error");
                        element.insertAdjacentElement("beforebegin", DivEntrada);
                        let entradaP = document.createElement("p");
                        entradaP.textContent = `El telefono tiene mas caracter de lo permitido`;
                        DivEntrada.appendChild(entradaP);
                    } else if ((element.value.length < 8)) {
                        const DivEntrada = document.createElement("div");
                        DivEntrada.classList.add("ticket-error");
                        element.insertAdjacentElement("beforebegin", DivEntrada);
                        let entradaP = document.createElement("p");
                        entradaP.textContent = `El telefono tiene Menos caracter de lo permitido`;
                        DivEntrada.appendChild(entradaP);
                    } else {
                        if (!/^\d+$/.test(element.value)) {
                            const DivEntrada = document.createElement("div");
                            DivEntrada.classList.add("ticket-error");
                            element.insertAdjacentElement("beforebegin", DivEntrada);
                            let entradaP = document.createElement("p");
                            entradaP.textContent = `El telefon tiene caracter no numericos`;
                            DivEntrada.appendChild(entradaP);
                        }
                    }
                } else {
                    const DivEntrada = document.createElement("div");
                    DivEntrada.classList.add("ticket-error");
                    element.insertAdjacentElement("beforebegin", DivEntrada);
                    let entradaP = document.createElement("p");
                    entradaP.textContent = `El telefon no puede estar vacio`;
                    DivEntrada.appendChild(entradaP);
                }
            });
            if (document.querySelectorAll(".ticket-error").length > 0) {
                return false;
            } else {
                return true;
            }

        }

        function ErroresdelTelefono() {
            document.querySelectorAll('#telefonComprador').forEach(element => {
                element.addEventListener('keyup', function() {
                    var telefonoInput = this.value;
                    if (!/^\d+$/.test(telefonoInput)) {
                        mensajeError.textContent =
                            'El número de teléfono solo puede contener dígitos numéricos.';
                        divError.style.display = "block";
                        esError = true;
                    } else if (telefonoInput.length > 9) {
                        mensajeError.textContent =
                            'El número de teléfono no puede tener más de 10 dígitos.';
                        divError.style.display = "block";
                        esError = true;
                    } else {
                        esError = false;
                        divError.style.display = "none";
                    }

                });
            });
        }
        ErroresdelTelefono();
        setTimeout(function() {
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
        verFecha.textContent = `Fecha: ${fecha(sessionArray.data)}`;
        verHora.textContent = `Hora: ${hora(sessionArray.data)}`;


        comprar.addEventListener('click', function(e) {
            e.preventDefault();
            if (mirarTodosLosErrores()) {
                document.getElementById("ComprarEntrada").submit();
            }
        })
    </script>
@endsection
