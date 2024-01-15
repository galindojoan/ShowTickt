@extends('layouts.master')

@section('title', 'crear')

@section('content')
    <div id="content-container">
        <form action="{{ route('crear-esdeveniment.store') }}" method="post" class="addEvent" enctype="multipart/form-data">
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

            <button type="submit" class="btn btn-add">Crear Esdeveniment</button>
        </form>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var recinteSelect = document.getElementById('recinteSelect');
        var nousCamps = document.getElementById('nousCamps');
        var cancelarBoto = document.getElementById('cancelarBoto');
        var novaAdrecaBoto = document.getElementById('mostrarNovaAdreca');

        // Afegir un esdeveniment d'escolta al botó "Afegir Nova Adreça"
        document.getElementById('mostrarNovaAdreca').addEventListener('click', function() {
            recinteSelect.value = ''; // Estableix el valor del select com a buit
            recinteSelect.style.display = 'none'; // Oculta el select
            nousCamps.style.display = 'block'; // Mostra els nous camps
            cancelarBoto.style.display = 'inline-block'; // Mostra el botó de cancelar
            novaAdrecaBoto.style.display = 'none';
        });

        // Afegir un esdeveniment d'escolta al botó "Cancelar"
        cancelarBoto.addEventListener('click', function() {
            recinteSelect.style.display = 'block'; // Mostra el select
            nousCamps.style.display = 'none'; // Oculta els nous camps
            cancelarBoto.style.display = 'none'; // Oculta el botó de cancelar
            novaAdrecaBoto.style.display = 'block';
        });
    });
</script>
@endsection
