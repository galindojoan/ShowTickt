@extends('layouts.master')

@section('title', 'Añadir Sesion')
@section('metadades', 'Añade otra fecha a un evento ya creado.')

@section('content')
    <div id="content-container">
        <form action="{{ route('peticionSesion') }}" method="post" class="addEvent" id="addEvent"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="event-id" value="{{ $id }}">
            <div class="form-group">
                <label for="data_hora" class="form-label">Fecha y hora de la celebración</label>
                <input type="datetime-local" class="form-controller" id="data_hora" name="data_hora" required>
                <div id="errorDivdata" class="errorDiv" style="display: none;">
                    <div id="errorContent">
                        <div class="error-message" id="error-data"></div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="aforament_maxim" class="form-label">Aforo máximo</label>
                <input type="number" class="form-controller" id="aforament_maxim" name="aforament_maxim" required>
                <div id="errorDivaforo" class="errorDiv" style="display: none;">
                    <div id="errorContent">
                        <div class="error-message" id="error-aforo"></div>
                    </div>
                </div>
            </div>

            <!-- Tipos de Entradas -->
            <div class="form-group">
                <h2>Tipos de Entradas</h2>
                <div id="tiposEntradas">
                    <!-- Contenido dinámico para los tipos de entradas -->
                </div>
                <div id="errorDiventrada" class="errorDiv" style="display: none;">
                    <div id="errorContent">
                        <div class="error-message" id="error-entrada"></div>
                    </div>
                </div>
                <div class="button-container">
                    <button type="button" class="btn btn-blue" id="agregarTipoEntrada">Agregar Tipo de Entrada</button>
                    <button type="button" class="btn btn-red" id="eliminarTipoEntrada" style="display: none;">Eliminar
                        Entrada</button>
                </div>
            </div>

            <div class="form-group">
                <label for="tancamentVenda" class="form-label">Fecha de cierre de ventas</label>
                <select id="tancamentVenda" class="form-select" name="tancamentVenda">
                    <option value="esdeveniment">Inicio de la celebración</option>
                    <option value="1hora">1 hora antes</option>
                    <option value="2hores">2 horas antes</option>
                    <option value="personalitzat">Personalizado (escogemos fecha y hora)</option>
                </select>

                <div id="personalitzatTancament" style="display: none;">
                    <label for="dataHoraPersonalitzada" class="form-label">Fecha y hora del cierre</label>
                    <input type="datetime-local" class="form-controller" id="dataHoraPersonalitzada"
                        name="dataHoraPersonalitzada">
                    <div id="errorDivtancament" class="errorDiv" style="display: none;">
                        <div id="errorContent">
                            <div class="error-message" id="error-tancament"></div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="form-group">
                <label for="entradaNominal" class="form-label">Entradas Nominales</label>
                <input type="checkbox" id="entradaNominal" name="entradaNominal">
            </div>

            <!-- Afegir a la part inferior del teu document -->
            <div id="errorDiv" style="display: none;">
                <div id="errorContent">
                    <!-- El missatge d'error es mostrarà aquí -->
                </div>
            </div>

            <div id="errorDiv" class="errorDiv" style="display: none;">
                <div id="errorContent">
                    <div class="error-message" id="error-message"></div>
                </div>
            </div>

            <button type="button" class="btn btn-blue" id="validarYCrear">Añadir Sesión</button>

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

            agregarTipoEntrada.addEventListener('click', function() {
                var nuevoTipoEntrada = document.createElement('div');
                var index = document.querySelectorAll('.tipo-entrada').length + 1;

                nuevoTipoEntrada.innerHTML = `
<div class="tipo-entrada">
<label for="entrades-nom" class="form-label">Nombre del Tipo</label>
<input type="text" maxlength="20" class="form-controller" name="entrades-nom[]" required>
<div id="errorDivnomEntrada" class="errorDiv" style="display: none;">
                <div id="errorContent">
    <div class="error-message" id="error-nomEntrada"></div>
    </div>
    </div>

<label for="entrades-preu" class="form-label">Precio</label>
<input type="text" class="form-controller" name="entrades-preu[]" required>
<div id="errorDivpreu" class="errorDiv" style="display: none;">
                <div id="errorContent">
    <div class="error-message" id="error-preu"></div>
    </div>
    </div>

<label for="entrades-quantitat" class="form-label">Cantidad disponible</label>
<input type="number" class="form-controller" name="entrades-quantitat[]" required>
<div id="errorDivquantitat" class="errorDiv" style="display: none;">
                <div id="errorContent">
    <div class="error-message" id="error-quantitat"></div>
    </div>
    </div>
</div>

`;

                tiposEntradas.appendChild(nuevoTipoEntrada);

                // Mostrar el botón de eliminar si hay al menos un tipo de entrada
                var eliminarTipoEntradaButton = document.getElementById('eliminarTipoEntrada');
                eliminarTipoEntradaButton.style.display = 'block';
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
                    mostrarMissatge('entrada', 'Debe haber al menos un tipo de entrada.');
                } else {
                    ocultarMissatge('entrada');
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
                    mostrarMissatge('data', 'El campo de fecha y hora de la celebración no puede estar vacío.');
                    return false;
                } else {
                    ocultarMissatge('data');
                }

                var fechaHoraActual = new Date();
                // Obtener la fecha y hora del evento
                var fechaHoraEvento = new Date(dataHoraEsdevenimentInput.value);

                // Verificar que la fecha del evento no sea anterior a la fecha y hora actual
                if (fechaHoraEvento < fechaHoraActual) {
                    mostrarMissatge('data',
                        'La fecha y hora de inicio del evento no puede ser anterior a la fecha y hora actual.');
                    return false;
                } else {
                    ocultarMissatge('data');
                }

                if (aforoValue === '') {
                    mostrarMissatge('aforo', 'El campo de aforo máximo no puede estar vacío.');
                    return false;
                } else {
                    ocultarMissatge('aforo');
                }

                if (isNaN(aforoValue)) {
                    mostrarMissatge('aforo', 'El valor del aforo máximo debe ser numérico.');
                    return false;
                } else {
                    ocultarMissatge('aforo');
                }

                if (parseInt(aforoValue) < 1) {
                    mostrarMissatge('aforo', 'El aforo debe ser de almenos 1 persona.')
                    return false;
                } else {
                    ocultarMissatge('aforo');
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
                        mostrarMissatge('nomEntrada',
                            'El nombre del tipo de entrada no puede estar vacío.')
                        return false;
                    } else {
                        ocultarMissatge('nomEntrada');
                    }

                    if (nombreValue.length > 20) {
                        mostrarMissatge('nomEntrada',
                            'El nombre del tipo de entrada debe tener máximo 20 caracteres.')
                        return false;
                    } else {
                        ocultarMissatge('nomEntrada');
                    }

                    if (precioValue === '' || isNaN(precioValue) || parseFloat(precioValue) <= 0) {
                        mostrarMissatge('preu', 'El precio debe ser un valor numérico mayor que 0.');
                        return false;
                    } else {
                        ocultarMissatge('preu');
                    }

                    // Validar que el precio no supere el límite
                    if (parseFloat(precioValue) > 1000) {
                        mostrarMissatge('preu', 'El precio no puede ser superior a 1.000.€');
                        return false;
                    } else {
                        ocultarMissatge('preu');
                    }

                    if (cantidadValue !== '' && (isNaN(cantidadValue) || parseInt(cantidadValue) <= 0)) {
                        mostrarMissatge('quantitat',
                            'La cantidad disponible debe ser un valor numérico mayor que 0.');
                        return false;
                    } else {
                        ocultarMissatge('quantitat');
                    }
                }

                if (tancamentVendaSelect.value === 'personalitzat' && personalitzatTancamentDiv.style.display !==
                    'none') {
                    var dataHoraPersonalitzadaValue = dataHoraPersonalitzadaInput.value.trim();
                    if (dataHoraPersonalitzadaValue === '') {
                        mostrarMissatge('tancament', 'La fecha y hora personalizada no puede estar vacía.');
                        return false;
                    } else {
                        ocultarMissatge('tancament');
                    }

                    var fechaHoraActual = new Date();
                    // Obtener la fecha y hora del evento
                    var fechaHoraCierre = new Date(dataHoraPersonalitzadaInput.value);

                    // Verificar que la fecha del evento no sea anterior a la fecha y hora actual
                    if (fechaHoraCierre < fechaHoraActual) {
                        mostrarMissatge('tancament',
                            'La fecha y hora de cierre de ventas del evento no puede ser anterior a la fecha y hora actual.'
                        );
                        return false;
                    } else {
                        ocultarMissatge('tancament');
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
                        mostrarMissatge('entrada', 'Debe agregar al menos una entrada antes de crear el evento.');
                    } else {
                        ocultarMissatge('entrada');
                        // Realitzar les validacions addicionals
                        if (verificarQuantitats()) {
                            // Si tot està bé, enviar el formulari
                            if (validarDataTancament()) {
                                document.getElementById('addEvent').submit();
                            } else {
                                mostrarMissatge('tancament',
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
                        mostrarMissatge('quantitat',
                            'La cantidad disponible para este tipo de entrada no puede superar la capacidad total del local.'
                        );
                        return false; // Evitar l'enviament del formulari
                    } else {
                        ocultarMissatge('quantitat');
                    }
                }

                // Verifica que el total de quantitats disponibles no superi l'aforament màxim
                if (totalQuantitats > aforamentMaxim) {
                    mostrarMissatge('quantitat',
                        'La suma total de cantidades de entradas disponibles no puede superar el aforo máximo.'
                    );
                    return false; // Evitar l'enviament del formulari
                } else {
                    ocultarMissatge('quantitat');
                }

                // Si tot està bé, permet l'enviament del formulari
                return true;
            }

            function mostrarMissatge(campo, missatge) {
                // Mostrar el missatge d'error
                var errorDiv = document.getElementById('errorDiv' + campo);
                var errorContent = document.getElementById('errorContent');
                var errorCampo = document.getElementById('error-' + campo);
                var errorForm = document.getElementById('errorDiv');
                var errorMessage = document.getElementById('error-message');

                errorCampo.innerHTML = missatge
                errorMessage.innerHTML = "El formulario contiene errores!";
                errorForm.style.display = 'block';
                errorDiv.style.display = 'block';
            }

            function ocultarMissatge(campo) {
                var errorDiv = document.getElementById('errorDiv' + campo);
                errorDiv.style.display = 'none';
            }

        });
    </script>

@endsection
