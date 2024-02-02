@extends('layouts.master')

@section('title', 'crear')

@section('content')
    <div id="nousCamps" style="display: none;">
        <div class="form-group">
            <label for="nova_nom" class="form-label">Nombre del Local</label>
            <input type="text" class="form-controller" id="nova_nom" name="nova_nom"
                value="{{ old('nova_nom') }}">
            <div id="errorDivnomLocal" class="errorDiv" style="display: none;">
                <div id="errorContent">
                    <div class="error-message" id="error-nomLocal"></div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="nova_provincia" class="form-label">Provincia</label>
            <input type="text" class="form-controller" id="nova_provincia" name="nova_provincia"
                value="{{ old('nova_provincia') }}">
            <div id="errorDivprovincia" class="errorDiv" style="display: none;">
                <div id="errorContent">
                    <div class="error-message" id="error-provincia"></div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="nova_ciutat" class="form-label">Ciudad</label>
            <input type="text" class="form-controller" id="nova_ciutat" name="nova_ciutat"
                value="{{ old('nova_ciutat') }}">
            <div id="errorDivciutat" class="errorDiv" style="display: none;">
                <div id="errorContent">
                    <div class="error-message" id="error-ciutat"></div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="nova_carrer" class="form-label">Nombre de la calle</label>
            <input type="text" class="form-controller" id="nova_carrer" name="nova_carrer"
                value="{{ old('nova_carrer') }}">
            <div id="errorDivcarrer" class="errorDiv" style="display: none;">
                <div id="errorContent">
                    <div class="error-message" id="error-carrer"></div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="nova_numero" class="form-label">Número de la calle</label>
            <input type="text" class="form-controller" id="nova_numero" name="nova_numero"
                value="{{ old('nova_numero') }}">
            <div id="errorDivnumero" class="errorDiv" style="display: none;">
                <div id="errorContent">
                    <div class="error-message" id="error-numero"></div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="nova_codi_postal" class="form-label">Codigo Postal</label>
            <input type="number" maxlength="5" class="form-controller" id="nova_codi_postal"
                name="nova_codi_postal" value="{{ old('nova_codi_postal') }}">
            <div id="errorDivpostal" class="errorDiv" style="display: none;">
                <div id="errorContent">
                    <div class="error-message" id="error-postal"></div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="nova_capacitat" class="form-label">Aforo</label>
            <input type="number" class="form-controller" id="nova_capacitat" name="nova_capacitat"
                value="{{ old('nova_capacitat') }}">
            <div id="errorDivcapacitat" class="errorDiv" style="display: none;">
                <div id="errorContent">
                    <div class="error-message" id="error-capacitat"></div>
                </div>
            </div>
        </div>

        <input type="hidden" name="nova_user_id" value="{{ session('user_id') }}">
        
    </div>
@endsection
@section('scripts')

@endsection