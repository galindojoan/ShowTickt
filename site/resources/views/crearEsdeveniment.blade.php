@extends('layouts.master')

@section('title', 'crear')

@section('content')
    <div id="content-container">
        <form action="{{ route('crear-esdeveniment.store') }}" method="post" class="addEvent" id="addEvent"
            enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="user_id" id="user_id" value="{{ session('user_id') }}">

            <div class="form-group">
                <label for="titol" class="form-label">Título del evento</label>
                <input type="text" class="form-controller" id="titol" name="titol" required>
            </div>

            <div class="form-group">
                <label for="categoria" class="form-label">Categoría</label>
                <select class="form-select" id="categoria" name="categoria" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->tipus }}</option>
                    @endforeach
                </select>
            </div>

            @if (isset($noRecintes) && $noRecintes)
                <div id="nousCamps" style="display: block;">
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
                        <input type="text" class="form-controller" id="nova_codi_postal" name="nova_codi_postal">
                    </div>

                    <div class="form-group">
                        <label for="nova_capacitat" class="form-label">Aforo</label>
                        <input type="text" class="form-controller" id="nova_capacitat" name="nova_capacitat">
                    </div>

                    <input type="hidden" name="nova_user_id" value="{{ session('user_id') }}">
                </div>
            @else
                <div class="form-group">
                    <label for="recinte" class="form-label">Recinte</label>
                    <select class="form-select" id="recinteSelect" name="recinte">
                        <option value="">Selecciona un recinte existent</option>
                        @foreach ($recintes as $recinte)
                            <option value="{{ $recinte->id }}">{{ $recinte->nom }}</option>
                        @endforeach
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
                        <input type="text" class="form-controller" id="nova_codi_postal" name="nova_codi_postal">
                    </div>

                    <div class="form-group">
                        <label for="nova_capacitat" class="form-label">Aforo</label>
                        <input type="text" class="form-controller" id="nova_capacitat" name="nova_capacitat">
                    </div>

                    <input type="hidden" name="nova_user_id" value="{{ session('user_id') }}">
                </div>

                <button type="button" id="cancelarBoto" style="display: none;">Cancelar</button>
            @endif

            <div class="form-group">
                <label for="imatge" class="form-label">Imagen principal del evento</label>
                <input type="file" class="form-controller" id="imatge" name="imatge" accept="image/*" required>
            </div>

            <div class="form-group">
                <label for="descripcio" class="form-label">Descripción del evento</label>
                <textarea class="form-controller" id="descripcio" name="descripcio" rows="3" required></textarea>
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
            </div>

            <div class="form-group">
                <label for="tancamentVenda" class="form-label">Tancament de la venda en línia</label>
                <select id="tancamentVenda" class="form-select" name="tancamentVenda">
                    <option value="esdeveniment">A l'hora de celebració de l'esdeveniment</option>
                    <option value="1hora">1 hora abans</option>
                    <option value="2hores">2 hores abans</option>
                    <option value="personalitzat">Personalitzat (triem data i hora)</option>
                </select>

                <div id="personalitzatTancament" style="display: none;">
                    <label for="dataHoraPersonalitzada" class="form-label">Data i hora de tancament</label>
                    <input type="datetime-local" class="form-controller" id="dataHoraPersonalitzada"
                        name="dataHoraPersonalitzada">
                </div>
            </div>

            <div class="form-group">
                <label for="ocultarEsdeveniment" class="form-label">Esdeveniment Ocult</label>
                <input type="checkbox" id="ocultarEsdeveniment" name="ocultarEsdeveniment">
            </div>

            <div class="form-group">
                <label for="entradaNominal" class="form-label">Entrades Nominals</label>
                <input type="checkbox" id="entradaNominal" name="entradaNominal">
            </div>

            <button type="button" class="btn btn-add" id="validarYCrear">Crear Esdeveniment</button>
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
    <input type="text" class="form-controller" name="entrades-nom[]" required>

    <label for="entrades-preu" class="form-label">Precio</label>
    <input type="text" class="form-controller" name="entrades-preu[]" required>

    <label for="entrades-quantitat" class="form-label">Cantidad disponible</label>
    <input type="number" class="form-controller" name="entrades-quantitat[]" required>
</div>

    `;

                tiposEntradas.appendChild(nuevoTipoEntrada);
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

            validarYCrear.addEventListener('click', function() {
                establirValorPerDefecte();
                // Obtener la lista de entradas
                var entradas = document.querySelectorAll('.tipo-entrada');

                // Verificar que haya al menos una entrada
                if (entradas.length === 0) {
                    alert('Debe agregar al menos una entrada antes de crear el evento.');
                } else {
                    // Realitzar les validacions addicionals
                    if (verificarQuantitats()) {
                        // Si tot està bé, enviar el formulari
                        if (validarDataTancament()) {
                            document.getElementById('addEvent').submit();
                        } else {
                            alert('La data de tancament ha de ser anterior o igual a la data de l\'esdeveniment.');
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
                        alert(
                            'La quantitat disponible per a aquest tipus d\'entrada no pot superar la capacitat total del local.'
                        );
                        return false; // Evitar l'enviament del formulari
                    }
                }

                // Verifica que el total de quantitats disponibles no superi l'aforament màxim
                if (totalQuantitats > aforamentMaxim) {
                    alert('La suma total de quantitats d\'entrades disponibles no pot superar l\'aforament màxim.');
                    return false; // Evitar l'enviament del formulari
                }

                // Si tot està bé, permet l'enviament del formulari
                return true;
            }

        });
    </script>
@endsection
