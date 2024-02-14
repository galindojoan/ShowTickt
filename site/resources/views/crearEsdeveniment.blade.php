@extends('layouts.master')

@section('title', 'crear')
@section('metadades', 'Crea un evento nuevo.')

@section('content')
    <div id="content-container">
        <form action="{{ route('crear-esdeveniment.store') }}" method="post" class="addEvent" id="addEvent"
            enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="user_id" id="user_id" value="{{ session('user_id') }}">

            <div class="form-group">
                <label for="titol" class="form-label">Título del evento</label>
                <input type="text" maxlength="20" class="form-controller" id="titol" name="titol"
                    value="{{ old('titol') }}" required>
                <div id="errorDivtitol" class="errorDiv" style="display: none;">
                    <div id="errorContent">
                        <div class="error-message" id="error-titol"></div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="categoria" class="form-label">Categoría</label>
                <select class="form-select" id="categoria" name="categoria" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('categoria') == $category->id ? 'selected' : '' }}>
                            {{ $category->tipus }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group @if (count($recintes) === 0) d-none @endif">
                <label for="recinte" class="form-label">Recinto</label>
                <select class="form-select" id="recinteSelect" name="recinte">
                    @if (count($recintes) === 0)
                        <option value="" selected disabled>No hay recintos disponibles</option>
                    @else
                        <option value="">Selecciona un recinto existente</option>
                        @foreach ($recintes as $recinte)
                            <option value="{{ $recinte->id }}" {{ old('recinte') == $recinte->id ? 'selected' : '' }}>
                                {{ $recinte->nom }}</option>
                        @endforeach
                    @endif
                </select>
                <div id="errorDivrecinte" class="errorDiv" style="display: none;">
                    <div id="errorContent">
                        <div class="error-message" id="error-recinte"></div>
                    </div>
                </div>
            </div>

            @if (session('error'))
                <div class="alertDiv">
                    {{ session('error') }}
                </div>
            @endif

            <div class="form-group">
                <a href="{{ route('crear-recinte') }}" id="mostrarNovaAdreca" class="btn btn-blue">Añadir nueva
                    dirección</a>
            </div>

            <div class="form-group">
                <label for="imatge" class="form-label">Imagen principal del evento</label>
                <input type="file" class="form-controller" id="imatge" name="imatge[]" accept="image/*"
                    value="{{ old('imatge') }}" multiple required>
                <div id="errorDivimatge" class="errorDiv" style="display: none;">
                    <div id="errorContent">
                        <div class="error-message" id="error-imatge"></div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="descripcio" class="form-label">Descripción del evento</label>
                <textarea type="textarea" class="form-controller" maxlength="640" id="descripcio" name="descripcio" rows="3"
                    required>{{ old('descripcio') }}</textarea>
                <div id="errorDivdescripcio" class="errorDiv" style="display: none;">
                    <div id="errorContent">
                        <div class="error-message" id="error-descripcio"></div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="data_hora" class="form-label">Fecha y hora de la celebración</label>
                <input type="datetime-local" class="form-controller" id="data_hora" name="data_hora"
                    value="{{ old('data_hora') }}" required>
                <div id="errorDivdata" class="errorDiv" style="display: none;">
                    <div id="errorContent">
                        <div class="error-message" id="error-data"></div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="aforament_maxim" class="form-label">Aforo máximo</label>
                <input type="number" class="form-controller" id="aforament_maxim" name="aforament_maxim"
                    value="{{ old('aforament_maxim') }}" required>
                <div id="errorDivaforo" style="display: none;">
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
                <div class="button-entrada">
                    <button type="button" class="btn btn-blue" id="agregarTipoEntrada">Agregar Tipo de
                        Entrada</button>
                    <button type="button" class="btn btn-eliminar" id="eliminarTipoEntrada"
                        style="display: none;">Eliminar
                        Entrada</button>
                </div>
            </div>

            <div class="form-group">
                <label for="tancamentVenda" class="form-label">Fecha de cierre de ventas</label>
                <select id="tancamentVenda" class="form-select" name="tancamentVenda">
                    <option value="esdeveniment" {{ old('tancamentVenda') == 'esdeveniment' ? 'selected' : '' }}>
                        Inicio de la celebración
                    </option>
                    <option value="1hora" {{ old('tancamentVenda') == '1hora' ? 'selected' : '' }}>
                        1 hora antes
                    </option>
                    <option value="2hores" {{ old('tancamentVenda') == '2hores' ? 'selected' : '' }}>
                        2 horas antes
                    </option>
                    <option value="personalitzat" {{ old('tancamentVenda') == 'personalitzat' ? 'selected' : '' }}>
                        Personalizado (escogemos fecha y hora)
                    </option>
                </select>

                <div id="personalitzatTancament" style="display: none;">
                    <label for="dataHoraPersonalitzada" class="form-label">Fecha y hora del cierre</label>
                    <input type="datetime-local" class="form-controller" id="dataHoraPersonalitzada"
                        name="dataHoraPersonalitzada" value="{{ old('dataHoraPersonalitzada') }}">
                    <div id="errorDivtancament" class="errorDiv" style="display: none;">
                        <div id="errorContent">
                            <div class="error-message" id="error-tancament"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="ocultarEsdeveniment" class="form-label">Evento Oculto</label>
                <input type="checkbox" id="ocultarEsdeveniment" name="ocultarEsdeveniment"
                    @if (old('ocultarEsdeveniment')) checked @endif>
            </div>

            <div id="errorDiv" class="errorDiv" style="display: none;">
                <div id="errorContent">
                    <div class="error-message" id="error-message"></div>
                </div>
            </div>

            <button type="button" class="btn btn-blue" id="validarYCrear">Crear Evento</button>

        </form>
    </div>
    <script>
        let recinteSelect = document.getElementById('recinteSelect');
        let tiposEntradas = document.getElementById('tiposEntradas');
        let agregarTipoEntrada = document.getElementById('agregarTipoEntrada');
        let tancamentVendaSelect = document.getElementById('tancamentVenda');
        let personalitzatTancamentDiv = document.getElementById('personalitzatTancament');
        let dataHoraPersonalitzadaInput = document.getElementById('dataHoraPersonalitzada');
        let dataHoraEsdevenimentInput = document.getElementById('data_hora');
        let titol = document.getElementById('titol');
        let nousCamps = document.getElementById('nousCamps');
        let imatgeInput = document.getElementById('imatge');
        let descripcionInput = document.getElementById('descripcio');
        let fechaHoraInput = document.getElementById('data_hora');
        let aforoInput = document.getElementById('aforament_maxim');

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
        // Funció per validar la data de tancament
        function validarDataTancament() {
            var dataEsdeveniment = new Date(dataHoraEsdevenimentInput.value);
            var dataTancament = new Date(dataHoraPersonalitzadaInput.value);

            // Comprova si la data de tancament és anterior o igual a la data de l'esdeveniment
            return dataTancament <= dataEsdeveniment;
        }

        function validarCamposVacios() {
            if (titol.value === '') {
                mostrarMissatge('titol', 'El título del evento es un campo obligatorio');
                return false;
            } else if (titol.length > 20) {
                mostrarMissatge('titol', 'El título del evento no puede tener más de 20 caracteres.');
                return false;
            } else {
                ocultarMissatge('titol');
            }

            if (imatgeInput.files.length === 0) {
                mostrarMissatge('imatge', 'Debe seleccionar una imagen para el evento.');
                return false;
            } else if (imatgeInput.files.length > 0) {
                var allowedTypes = ['image/jpeg', 'image/png', 'image/bmp', 'image/webp',
                    'image/jpg'
                ]; // Tipos de archivo permitidos
                var selectedFileType = imatgeInput.files[0].type;

                // Verificar si el tipo de archivo está permitido
                if (allowedTypes.indexOf(selectedFileType) === -1) {
                    mostrarMissatge('imatge',
                        'El archivo seleccionado no es una imagen válida. Por favor, elige un archivo JPEG, PNG, BMP o WebP.'
                    );
                    // Limpiar el campo de imatge
                    imatgeInput.value = '';
                    return false;
                } else {
                    ocultarMissatge('imatge');
                }
            }

            if (descripcionInput.value === '') {
                mostrarMissatge('descripcio', 'La descripción del evento no puede estar vacía.');
                return false;
            } else if (descripcionInput.length > 640) {
                mostrarMissatge('descripcio',
                    'La descripción del evento debe tener un máximo de 640 caracteres.');
                return false;
            } else {
                ocultarMissatge('descripcio');
            }

            if (fechaHoraInput.value === '') {
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

            if (aforoInput.value === '') {
                mostrarMissatge('aforo', 'El campo de aforo máximo no puede estar vacío.');
                return false;
            } else {
                ocultarMissatge('aforo');
            }

            // Obtener el valor del campo novaCapacitat
            var novaCapacitatInput = document.getElementById('nova_capacitat');

            // Verificar que novaCapacitat no esté vacío
            if (novaCapacitatInput !== '') {

                // Verificar que el aforo máximo no supere el valor de novaCapacitat
                if (aforoInput > parseInt(novaCapacitatInput)) {
                    mostrarMissatge('aforo', 'El aforo máximo no puede superar la capacidad del local.');
                    return false; // Evitar el envío del formulario
                } else {
                    ocultarMissatge('aforo');
                }
            }

            if (isNaN(aforoInput.value)) {
                mostrarMissatge('aforo', 'El valor del aforo máximo debe ser numérico.');
                return false;
            } else {
                ocultarMissatge('aforo');
            }

            if (parseInt(aforoInput.value) < 1) {
                mostrarMissatge('aforo', 'El aforo debe ser de almenos 1 persona.')
                return false;
            } else {
                ocultarMissatge('aforo');
            }

            var entradas = document.querySelectorAll('.tipo-entrada');
            console.log('no ');
            for (let i = 0; i < entradas.length; i++) {
                let entrada = entradas[i];
                let nombreInput = entrada.querySelector('[name="entrades-nom[]"]');
                console.log('precio');
                let precioInput = entrada.querySelector('[name="entrades-preu[]"]');
                console.log(precioInput);
                let cantidadInput = entrada.querySelector('[name="entrades-quantitat[]"]');
                if (nombreInput.value === '') {
                    mostrarMissatge('nomEntrada',
                        'El nombre del tipo de entrada no puede estar vacío.')
                    return false;
                } else {
                    ocultarMissatge('nomEntrada');
                }

                if (nombreInput.length > 20) {
                    'nomEntrada',
                    mostrarMissatge('El nombre del tipo de entrada debe tener máximo 20 caracteres.')
                    return false;
                }
                else {
                    ocultarMissatge('nomEntrada');
                }

                if (precioInput.value === '' || isNaN(precioInput.value) || parseFloat(precioInput.value) < 0) {
                    mostrarMissatge('preu', 'El precio debe ser un valor numérico mayor que 0.');
                    return false;
                } else {
                    ocultarMissatge('preu');
                }

                // Validar que el precio no supere el límite
                if (parseFloat(precioInput) > 1000) {
                    mostrarMissatge('preu', 'El precio no puede ser superior a 1.000.€');
                    return false;
                } else {
                    ocultarMissatge('preu');
                }

                if (cantidadInput.value !== '' && (isNaN(cantidadInput.value) || parseInt(cantidadInput.value) < 0)) {
                    mostrarMissatge('quantitat',
                        'La cantidad disponible debe ser un valor numérico mayor que 0.');
                    return false;
                } else {
                    ocultarMissatge('quantitat');
                }
            }

            if (tancamentVendaSelect.value === 'personalitzat' && personalitzatTancamentDiv.style.display !==
                'none') {
                if (dataHoraPersonalitzadaInput.value === '') {
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
                    ocultarMissatge('tancament', 'hola');
                }
            }

            return true;
        }

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
            // Mostrar el mensaje de error junto al campo correspondiente
            var errorDiv = document.getElementById('errorDiv' + campo);
            var errorContent = document.getElementById('errorContent');
            var errorCampo = document.getElementById('error-' + campo);
            var errorForm = document.getElementById('errorDiv');
            var errorMessage = document.getElementById('error-message');

            errorCampo.innerHTML = missatge;
            errorMessage.innerHTML = "El formulario contiene errores!";
            errorForm.style.display = 'block';
            errorDiv.style.display = 'block';
        }

        function ocultarMissatge(campo) {
            var errorDiv = document.getElementById('errorDiv' + campo);
            errorDiv.style.display = 'none';
        };
        document.addEventListener('DOMContentLoaded', function() {
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

                        <label for="entradaNominal" class="form-label">Entradas Nominales</label>
                        <input type="hidden" value="False" name="entradaNominalCheck[]" id="entradaNominalCheck">
                        <input type="checkbox" id="entradaNominal" name="entradaNominal[]"
                            @if (old('entradaNominal')) checked @endif>

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
                    </div>`;

                tiposEntradas.appendChild(nuevoTipoEntrada);

                // Mostrar el botón de eliminar si hay al menos un tipo de entrada
                var eliminarTipoEntradaButton = document.getElementById('eliminarTipoEntrada');
                eliminarTipoEntradaButton.style.display = 'block';

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

            tancamentVendaSelect.addEventListener('change', establirValorPerDefecte);



            validarYCrear.addEventListener('click', function() {
                establirValorPerDefecte();

                if (validarCamposVacios()) {
                    // Obtener la lista de entradas
                    var entradas = document.querySelectorAll('.tipo-entrada');

                    // Verificar que haya al menos una entrada
                    if (entradas.length === 0) {
                        mostrarMissatge('entrada',
                            'Debe agregar al menos una entrada antes de crear el evento.');
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
        });
    </script>
@endsection
