<?php $__env->startSection('title', 'crear'); ?>

<?php $__env->startSection('content'); ?>
    <div id="content-container">
        <form action="<?php echo e(route('crear-esdeveniment.store')); ?>" method="post" class="addEvent" id="addEvent"
            enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <input type="hidden" name="user_id" id="user_id" value="<?php echo e(session('user_id')); ?>">

            <div class="form-group">
                <label for="titol" class="form-label">Título del evento</label>
                <input type="text" maxlength="20" class="form-controller" id="titol" name="titol" required>
            </div>

            <div class="form-group">
                <label for="categoria" class="form-label">Categoría</label>
                <select class="form-select" id="categoria" name="categoria" required>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category->id); ?>"><?php echo e($category->tipus); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="form-group <?php if(count($recintes) === 0): ?> d-none <?php endif; ?>">
                <label for="recinte" class="form-label">Recinto</label>
                <select class="form-select" id="recinteSelect" name="recinte">
                    <?php if(count($recintes) === 0): ?>
                        <option value="" selected disabled>No hay recintos disponibles</option>
                    <?php else: ?>
                        <option value="">Selecciona un recinto existente</option>
                        <?php $__currentLoopData = $recintes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recinte): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($recinte->id); ?>"><?php echo e($recinte->nom); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="form-group">
                <button type="button" id="mostrarNovaAdreca" class="btn btn-add">Añadir nueva dirección</button>
            </div>

            <div id="nousCamps" style="display: none;">
                <div class="form-group">
                    <label for="nova_nom" class="form-label">Nombre del Local</label>
                    <input type="text" class="form-controller" id="nova_nom" name="nova_nom">
                </div>

                <div class="form-group">
                    <label for="nova_provincia" class="form-label">Provincia</label>
                    <input type="text" class="form-controller" id="nova_provincia" name="nova_provincia">
                </div>

                <div class="form-group">
                    <label for="nova_ciutat" class="form-label">Ciudad</label>
                    <input type="text" class="form-controller" id="nova_ciutat" name="nova_ciutat">
                </div>

                <div class="form-group">
                    <label for="nova_codi_postal" class="form-label">Codigo Postal</label>
                    <input type="number" maxlength="5" class="form-controller" id="nova_codi_postal"
                        name="nova_codi_postal">
                </div>

                <div class="form-group">
                    <label for="nova_capacitat" class="form-label">Aforo</label>
                    <input type="number" class="form-controller" id="nova_capacitat" name="nova_capacitat">
                </div>

                <input type="hidden" name="nova_user_id" value="<?php echo e(session('user_id')); ?>">
            </div>

            <button type="button" id="cancelarBoto" style="display: none;">Cancelar</button>

            <div class="form-group">
                <label for="imatge" class="form-label">Imagen principal del evento</label>
                <input type="file" class="form-controller" id="imatge" name="imatge" accept="image/*" required>
            </div>

            <div class="form-group">
                <label for="descripcio" class="form-label">Descripción del evento</label>
                <textarea class="form-controller" maxlength="640" id="descripcio" name="descripcio" rows="3" required></textarea>
            </div>

            <div class="form-group">
                <label for="data_hora" class="form-label">Fecha y hora de la celebración</label>
                <input type="datetime-local" class="form-controller" id="data_hora" name="data_hora" required>
            </div>

            <div class="form-group">
                <label for="aforament_maxim" class="form-label">Aforo máximo</label>
                <input type="number" class="form-controller" id="aforament_maxim" name="aforament_maxim" required>
            </div>

            <!-- Tipos de Entradas -->
            <div class="form-group">
                <h2>Tipos de Entradas</h2>
                <div id="tiposEntradas">
                    <!-- Contenido dinámico para los tipos de entradas -->
                </div>
                <button type="button" class="btn btn-add" id="agregarTipoEntrada">Agregar Tipo de Entrada</button>
                <button type="button" class="btn btn-remove" id="eliminarTipoEntrada" style="display: none;">Eliminar
                    Entrada</button>
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
                </div>
            </div>

            <div class="form-group">
                <label for="ocultarEsdeveniment" class="form-label">Evento Oculto</label>
                <input type="checkbox" id="ocultarEsdeveniment" name="ocultarEsdeveniment">
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

            <button type="button" class="btn btn-add" id="validarYCrear">Crear Evento</button>

        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var recinteSelect = document.getElementById('recinteSelect');
            var nousCamps = document.getElementById('nousCamps');
            var cancelarBoto = document.getElementById('cancelarBoto');
            var novaAdrecaBoto = document.getElementById('mostrarNovaAdreca');
            var tiposEntradas = document.getElementById('tiposEntradas');
            var agregarTipoEntrada = document.getElementById('agregarTipoEntrada');
            var tancamentVendaSelect = document.getElementById('tancamentVenda');
            var personalitzatTancamentDiv = document.getElementById('personalitzatTancament');
            var dataHoraPersonalitzadaInput = document.getElementById('dataHoraPersonalitzada');
            var dataHoraEsdevenimentInput = document.getElementById('data_hora');

            // Afegir un esdeveniment d'escolta al botó "Afegir Nova Adreça"
            document.getElementById('mostrarNovaAdreca').addEventListener('click', function() {
                recinteSelect.value = ''; // Estableix el valor del select com a buit
                recinteSelect.style.display = 'none'; // Oculta el select
                nousCamps.style.display = 'block'; // Mostra els nous camps
                cancelarBoto.style.display = 'block'; // Mostra el botó de cancelar
                novaAdrecaBoto.style.display = 'none';
            });

            // Afegir un esdeveniment d'escolta al botó "Cancelar"
            cancelarBoto.addEventListener('click', function() {
                recinteSelect.style.display = 'block'; // Mostra el select
                nousCamps.style.display = 'none'; // Oculta els nous camps
                cancelarBoto.style.display = 'none'; // Oculta el botó de cancelar
                novaAdrecaBoto.style.display = 'block';
            });

            agregarTipoEntrada.addEventListener('click', function() {
                var nuevoTipoEntrada = document.createElement('div');
                var index = document.querySelectorAll('.tipo-entrada').length + 1;

                nuevoTipoEntrada.innerHTML = `
<div class="tipo-entrada">
    <label for="entrades-nom" class="form-label">Nombre del Tipo</label>
    <input type="text" maxlength="20" class="form-controller" name="entrades-nom[]" required>

    <label for="entrades-preu" class="form-label">Precio</label>
    <input type="text" class="form-controller" name="entrades-preu[]" required>

    <label for="entrades-quantitat" class="form-label">Cantidad disponible</label>
    <input type="number" class="form-controller" name="entrades-quantitat[]" required>
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
                var titol = document.getElementById('titol').value.trim();
                var recinteSelect = document.getElementById('recinteSelect');
                var nousCamps = document.getElementById('nousCamps');
                var imatgeInput = document.getElementById('imatge');
                var descripcionInput = document.getElementById('descripcio');
                var descripcionValue = descripcionInput.value.trim();
                var fechaHoraInput = document.getElementById('data_hora');
                var fechaHoraValue = fechaHoraInput.value.trim();
                var aforoInput = document.getElementById('aforament_maxim');
                var aforoValue = aforoInput.value.trim();
                var tancamentVendaSelect = document.getElementById('tancamentVenda');
                var personalitzatTancamentDiv = document.getElementById('personalitzatTancament');
                var dataHoraPersonalitzadaInput = document.getElementById('dataHoraPersonalitzada');

                if (titol === '') {
                    mostrarMissatge('El título del evento es un campo obligatorio');
                    return false;
                }

                if (titol.length > 20) {
                    mostrarMissatge('El título del evento no puede tener más de 20 caracteres.');
                    return false;
                }

                if (recinteSelect.value === '' && nousCamps.style.display !== 'block') {
                    mostrarMissatge('Debe seleccionar un recinto existente o agregar una nueva dirección.');
                    return false;
                }

                if (nousCamps.style.display === 'block') {
                    var novaNom = document.getElementById('nova_nom').value.trim();
                    var novaProvincia = document.getElementById('nova_provincia').value.trim();
                    var novaCiutat = document.getElementById('nova_ciutat').value.trim();
                    var novaCodiPostal = document.getElementById('nova_codi_postal').value.trim();
                    var novaCapacitat = document.getElementById('nova_capacitat').value.trim();

                    // Validar que el código postal sea numérico
                    if (isNaN(novaCodiPostal)) {
                        mostrarMissatge('El código postal debe ser un valor numérico.');
                        return false;
                    }

                    // Validar que la capacidad sea numérica
                    if (isNaN(novaCapacitat)) {
                        mostrarMissatge('El aforo debe ser un valor numérico.');
                        return false;
                    }

                    if (novaNom === '' || novaProvincia === '' || novaCiutat === '' || novaCodiPostal === '' ||
                        novaCapacitat === '') {
                        mostrarMissatge('Todos los campos de dirección son obligatorios.');
                        return false;
                    }


                    // Validar que el código postal tenga el formato adecuado (5 dígitos)
                    var codiPostalRegExp = /^\d{5}$/;
                    if (!codiPostalRegExp.test(novaCodiPostal)) {
                        mostrarMissatge('El código postal debe tener 5 dígitos.');
                        return false;
                    }

                    if (parseInt(novaCapacitat) < 20) {
                        mostrarMissatge('El aforo no puede ser menor de 20.')
                        return false;
                    }
                }

                if (imatgeInput.files.length === 0) {
                    mostrarMissatge('Debe seleccionar una imagen para el evento.');
                    return false;
                }

                if (descripcionValue === '') {
                    mostrarMissatge('La descripción del evento no puede estar vacía.');
                    return false;
                }

                if (descripcionValue.length > 640) {
                    mostrarMissatge('La descripción del evento debe tener un máximo de 640 caracteres.');
                    return false;
                }

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\domin\Escritorio\gr6-arrua-galindo-jumelle\site\resources\views/crearEsdeveniment.blade.php ENDPATH**/ ?>