@extends('layouts.master')

@section('title', 'Añadir Sesion')
@section('metadades', 'Edita una sesión de tu evento para que los clientes vean los datos actualizados.')

@section('content')
    <div id="content-container">
        <form action="{{ route('cambiarSesion') }}" method="post" class="addEvent" id="addEvent" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="event-id" value="{{ $id }}">
            <input type="hidden" name="fecha-id" value="{{ $sessioId }}">
            <div class="form-group">
                <label for="data_hora" class="form-label">Fecha y hora de la celebración</label>
                <input type="datetime-local" class="form-controller" id="data_hora" name="data_hora"
                    value="{{ $sessiones->data }}" required>
            </div>

            <div class="form-group">
                <label for="aforament_maxim" class="form-label">Aforo máximo</label>
                <input type="number" class="form-controller" id="aforament_maxim" name="aforament_maxim"
                    value="{{ $sessiones->aforament }}" required>
            </div>

            <!-- Tipos de Entradas -->
            <div class="form-group">
                <h2>Tipos de Entradas</h2>
                <div id="tiposEntradas">
                    @foreach ($entradas as $entrada)
                        <div class="tipo-entrada">
                            <label for="entrades-nom" class="form-label">Nombre del Tipo</label>
                            <input type="text" maxlength="20" class="form-controller" name="entrades-nom[]"
                                required="" value="{{ $entrada->nom }}">

                            <label for="entrades-preu" class="form-label">Precio</label>
                            <input type="text" class="form-controller" name="entrades-preu[]" required=""
                                value="{{ $entrada->preu }}">

                            <label for="entradaNominal" class="form-label">Entradas Nominales</label>
                            <input type="hidden"
                                value="
                            @if ($entrada->nominal == true) True 
                            @else 
                            False @endif"
                                name="entradaNominalCheck[]" id="entradaNominalCheck">
                            <input type="checkbox" id="entradaNominal" name="entradaNominal[]"
                                @if ($entrada->nominal == true) checked @endif>

                            <label for="entrades-quantitat" class="form-label">Cantidad disponible</label>
                            <input type="number" class="form-controller" name="entrades-quantitat[]" required=""
                                value="{{ $entrada->quantitat }}">
                        </div>
                    @endforeach
                    <!-- Contenido dinámico para los tipos de entradas -->
                </div>
                <div class="button-entrada">
                    <button type="button" class="btn btn-add" id="agregarTipoEntrada">Agregar Tipo de Entrada</button>
                    <button type="button" class="btn btn-eliminar" id="eliminarTipoEntrada">Eliminar
                        Entrada</button>
                </div>
            </div>

            <div class="form-group">
                <div id="personalitzatTancament">
                    <label for="dataHoraPersonalitzada" class="form-label">Fecha y hora del cierre de ventas</label>
                    <input type="datetime-local" class="form-controller" id="dataHoraPersonalitzada"
                        value="{{ $sessiones->tancament }}" name="dataHoraPersonalitzada">
                </div>
            </div>

            <!-- Afegir a la part inferior del teu document -->
            <div id="errorDiv" style="display: none;">
                <div id="errorContent">
                    <!-- El missatge d'error es mostrarà aquí -->
                </div>
            </div>

            <button type="submit" class="btn btn-add" id="validarYCrear">Cambiar Sesión</button>

        </form>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tiposEntradas = document.getElementById('tiposEntradas');
            var agregarTipoEntrada = document.getElementById('agregarTipoEntrada');
            var tancamentVendaSelect = document.getElementById('tancamentVenda');
            var personalitzatTancamentDiv = document.getElementById('personalitzatTancament');
            var dataHoraPersonalitzadaInput = document.getElementById('dataHoraPersonalitzada');
            var dataHoraEsdevenimentInput = document.getElementById('data_hora');

            function checkboxCheck() {
                document.querySelectorAll('#entradaNominal').forEach(element => {
                element.addEventListener('click', function(e) {
                    let parent = element.parentNode;
                    if (element.checked) {
                        parent.querySelector('#entradaNominalCheck').value = 'True';
                    } else {
                        parent.querySelector('#entradaNominalCheck').value = 'False';
                    }
                })
            });
            }

            checkboxCheck();

            agregarTipoEntrada.addEventListener('click', function() {
                var nuevoTipoEntrada = document.createElement('div');
                var index = document.querySelectorAll('.tipo-entrada').length + 1;

                nuevoTipoEntrada.innerHTML = `
<div class="tipo-entrada">
<label for="entrades-nom" class="form-label">Nombre del Tipo</label>
<input type="text" maxlength="20" class="form-controller" name="entrades-nom[]" required>

<label for="entrades-preu" class="form-label">Precio</label>
<input type="text" class="form-controller" name="entrades-preu[]" required>


<label for="entradaNominal" class="form-label">Entradas Nominales</label>
                        <input type="hidden" value="False" name="entradaNominalCheck[]" id="entradaNominalCheck">
                        <input type="checkbox" id="entradaNominal" name="entradaNominal[]"
                            @if (old('entradaNominal')) checked @endif>

<label for="entrades-quantitat" class="form-label">Cantidad disponible</label>
<input type="number" class="form-controller" name="entrades-quantitat[]" required>
</div>

`;

                tiposEntradas.appendChild(nuevoTipoEntrada);

                // Mostrar el botón de eliminar si hay al menos un tipo de entrada
                var eliminarTipoEntradaButton = document.getElementById('eliminarTipoEntrada');
                eliminarTipoEntradaButton.style.display = 'block';
                checkboxCheck();
            });

            

            // Eliminar Último Tipo de Entrada
            eliminarTipoEntrada.addEventListener('click', function() {
                // Obtener el contenedor de tipos de entrada
                var tiposEntradasContainer = document.getElementById('tiposEntradas');

                // Obtener la lista de tipos de entrada
                var tiposEntradas = tiposEntradasContainer.querySelectorAll('.tipo-entrada');

                // Verificar que haya al menos un tipo de entrada para eliminar
                if (tiposEntradas.length > 1) {
                    // Obtener el último tipo de entrada
                    var ultimoTipoEntrada = tiposEntradas[tiposEntradas.length - 1];

                    // Eliminar el último tipo de entrada
                    ultimoTipoEntrada.parentNode.removeChild(ultimoTipoEntrada);
                }

                // Ocultar el botón de eliminar si no hay más tipos de entrada
                if (tiposEntradas.length <= 1) {
                    mostrarMissatge('Debe haber al menos un tipo de entrada.');
                } else {
                    var errorDiv = document.getElementById('errorDiv');
                    errorDiv.style.display = 'none';
                }
            });


            function establirValorPerDefecte() {
                var tancamentValue = tancamentVendaSelect.value;

                if (tancamentValue === 'personalitzat') {
                    personalitzatTancamentDiv.style.display = 'block';
                } else {
                    personalitzatTancamentDiv.style.display = 'none';

                    if (tancamentValue === '1hora' || tancamentValue === '2hores') {
                        // Calcula la data de tancament ajustant-hi les hores segons l'opció seleccionada
                        var dataEsdeveniment = new Date(dataHoraEsdevenimentInput.value);
                        var horesAbans = (tancamentValue === '1hora') ? 1 : 2;
                        var dataTancament = new Date(dataEsdeveniment.getTime() - (horesAbans - 1) * 60 * 60 *
                            1000);

                        // Formateja la data de tancament com a string per a l'input datetime-local
                        var dataTancamentString = dataTancament.toISOString().slice(0, -8);
                        dataHoraPersonalitzadaInput.value = dataTancamentString;
                    } else {
                        // Assigna la data de tancament en base a la selecció
                        dataHoraPersonalitzadaInput.value = dataHoraEsdevenimentInput.value;
                    }
                }
            }

            tancamentVendaSelect.addEventListener('change', establirValorPerDefecte);

            // Funció per validar la data de tancament
            function validarDataTancament() {
                var dataEsdeveniment = new Date(dataHoraEsdevenimentInput.value);
                var dataTancament = new Date(dataHoraPersonalitzadaInput.value);

                // Comprova si la data de tancament és anterior o igual a la data de l'esdeveniment
                return dataTancament <= dataEsdeveniment;
            }

            function validarCamposVacios() {
                var fechaHoraInput = document.getElementById('data_hora');
                var fechaHoraValue = fechaHoraInput.value.trim();
                var aforoInput = document.getElementById('aforament_maxim');
                var aforoValue = aforoInput.value.trim();
                var tancamentVendaSelect = document.getElementById('tancamentVenda');
                var personalitzatTancamentDiv = document.getElementById('personalitzatTancament');
                var dataHoraPersonalitzadaInput = document.getElementById('dataHoraPersonalitzada');


                if (fechaHoraValue === '') {
                    mostrarMissatge('El campo de fecha y hora de la celebración no puede estar vacío.');
                    return false;
                }

                if (aforoValue === '') {
                    mostrarMissatge('El campo de aforo máximo no puede estar vacío.');
                    return false;
                }

                if (isNaN(aforoValue)) {
                    mostrarMissatge('El valor del aforo máximo debe ser numérico.');
                    return false;
                }

                if (parseInt(aforoValue) < 20) {
                    mostrarMissatge('El aforo no puede ser menor de 20.')
                    return false;
                }

                var entradas = document.querySelectorAll('.tipo-entrada');

                for (var i = 0; i < entradas.length; i++) {
                    var entrada = entradas[i];
                    var nombreInput = entrada.querySelector('[name="entrades-nom[]"]');
                    var precioInput = entrada.querySelector('[name="entrades-preu[]"]');
                    var cantidadInput = entrada.querySelector('[name="entrades-quantitat[]"]');
                    var nombreValue = nombreInput.value.trim();
                    var precioValue = precioInput.value.trim();
                    var cantidadValue = cantidadInput.value.trim();
                    if (nombreValue === '') {
                        mostrarMissatge(
                            'El nombre del tipo de entrada no puede estar vacío.'
                        );
                        return false;
                    }

                    if (nombreValue.length > 20) {
                        mostrarMissatge('El nombre del tipo de entrada debe tener máximo 20 caracteres.')
                        return false;
                    }

                    if (precioValue === '' || isNaN(precioValue) || parseFloat(precioValue) <= 0) {
                        mostrarMissatge('El precio debe ser un valor numérico mayor que 0.');
                        return false;
                    }

                    // Validar que el precio no supere el límite
                    if (parseFloat(precioValue) > 1000) {
                        mostrarMissatge('El precio no puede ser superior a 1.000.€');
                        return false;
                    }

                    if (cantidadValue !== '' && (isNaN(cantidadValue) || parseInt(cantidadValue) <= 0)) {
                        mostrarMissatge('La cantidad disponible debe ser un valor numérico mayor que 0.');
                        return false;
                    }
                }

                if (tancamentVendaSelect.value === 'personalitzat' && personalitzatTancamentDiv.style.display !==
                    'none') {
                    var dataHoraPersonalitzadaValue = dataHoraPersonalitzadaInput.value.trim();
                    if (dataHoraPersonalitzadaValue === '') {
                        mostrarMissatge('La fecha y hora personalizada no puede estar vacía.');
                        return false;
                    }
                }

                return true;
            }

            validarYCrear.addEventListener('click', function() {
                establirValorPerDefecte();

                if (validarCamposVacios()) {
                    // Obtener la lista de entradas
                    var entradas = document.querySelectorAll('.tipo-entrada');

                    // Verificar que haya al menos una entrada
                    if (entradas.length === 0) {
                        mostrarMissatge('Debe agregar al menos una entrada antes de crear el evento.');
                    } else {
                        // Realitzar les validacions addicionals
                        if (verificarQuantitats()) {
                            // Si tot està bé, enviar el formulari
                            if (validarDataTancament()) {
                                document.getElementById('addEvent').submit();
                            } else {
                                mostrarMissatge(
                                    'La fecha de cierre de ventas debe ser anterior o igual a la fecha de inicio.'
                                );
                            }
                        }
                    }
                }
            });


            function verificarQuantitats() {
                var entradas = document.querySelectorAll('.tipo-entrada');
                var aforamentMaxim = parseInt(document.getElementById('aforament_maxim').value);
                var totalQuantitats = 0;

                for (var i = 0; i < entradas.length; i++) {
                    var entrada = entradas[i];
                    var quantitatInput = entrada.querySelector('[name="entrades-quantitat[]"]');
                    var quantitat = parseInt(quantitatInput.value);

                    // Assigna l'aforament màxim si el camp quantitat està buit
                    if (isNaN(quantitat) || quantitat <= 0) {
                        quantitatInput.value = aforamentMaxim;
                        quantitat = aforamentMaxim;
                    }

                    totalQuantitats += quantitat;

                    // Verifica que la quantitat no superi la capacitat total del local
                    if (quantitat > aforamentMaxim) {
                        mostrarMissatge(
                            'La cantidad disponible para este tipo de entrada no puede superar la capacidad total del local.'
                        );
                        return false; // Evitar l'enviament del formulari
                    }
                }

                // Verifica que el total de quantitats disponibles no superi l'aforament màxim
                if (totalQuantitats > aforamentMaxim) {
                    mostrarMissatge(
                        'La suma total de cantidades de entradas disponibles no puede superar el aforo máximo.'
                    );
                    return false; // Evitar l'enviament del formulari
                }

                // Si tot està bé, permet l'enviament del formulari
                return true;
            }

            function mostrarMissatge(missatge) {
                // Mostrar el missatge d'error
                var errorDiv = document.getElementById('errorDiv');
                var errorContent = document.getElementById('errorContent');
                errorContent.innerHTML = missatge;
                errorDiv.style.display = 'block';
            }

        });
    </script>

@endsection
