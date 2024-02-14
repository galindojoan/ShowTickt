<?php $__env->startSection('title', 'crear'); ?>
<?php $__env->startSection('metadades', 'Añade un nuevo local a la base de datos para poder añadirla al momento de crear tu evento.'); ?>


<?php $__env->startSection('content'); ?>
    <div id="content-container">
        <form action="<?php echo e(route('recinte-nou')); ?>" method="GET" id="nousCamps" class="addEvent" style="display: block;">
            <div class="form-group">
                <label for="nova_nom" class="form-label">Nombre del Local</label>
                <input type="text" class="form-controller" id="nova_nom" name="nova_nom" value="<?php echo e(old('nova_nom')); ?>">
                <div id="errorDivnomLocal" class="errorDiv" style="display: none;">
                    <div id="errorContent">
                        <div class="error-message" id="error-nomLocal"></div>
                    </div>
                </div>
            </div>
    
            <div class="form-group">
                <label for="nova_provincia" class="form-label">Provincia</label>
                <input type="text" class="form-controller" id="nova_provincia" name="nova_provincia"
                    value="<?php echo e(old('nova_provincia')); ?>">
                <div id="errorDivprovincia" class="errorDiv" style="display: none;">
                    <div id="errorContent">
                        <div class="error-message" id="error-provincia"></div>
                    </div>
                </div>
            </div>
    
            <div class="form-group">
                <label for="nova_ciutat" class="form-label">Ciudad</label>
                <input type="text" class="form-controller" id="nova_ciutat" name="nova_ciutat"
                    value="<?php echo e(old('nova_ciutat')); ?>">
                <div id="errorDivciutat" class="errorDiv" style="display: none;">
                    <div id="errorContent">
                        <div class="error-message" id="error-ciutat"></div>
                    </div>
                </div>
            </div>
    
            <div class="form-group">
                <label for="nova_carrer" class="form-label">Nombre de la calle</label>
                <input type="text" class="form-controller" id="nova_carrer" name="nova_carrer"
                    value="<?php echo e(old('nova_carrer')); ?>">
                <div id="errorDivcarrer" class="errorDiv" style="display: none;">
                    <div id="errorContent">
                        <div class="error-message" id="error-carrer"></div>
                    </div>
                </div>
            </div>
    
            <div class="form-group">
                <label for="nova_numero" class="form-label">Número de la calle</label>
                <input type="text" class="form-controller" id="nova_numero" name="nova_numero"
                    value="<?php echo e(old('nova_numero')); ?>">
                <div id="errorDivnumero" class="errorDiv" style="display: none;">
                    <div id="errorContent">
                        <div class="error-message" id="error-numero"></div>
                    </div>
                </div>
            </div>
    
            <div class="form-group">
                <label for="nova_codi_postal" class="form-label">Codigo Postal</label>
                <input type="number" maxlength="5" class="form-controller" id="nova_codi_postal" name="nova_codi_postal"
                    value="<?php echo e(old('nova_codi_postal')); ?>">
                <div id="errorDivpostal" class="errorDiv" style="display: none;">
                    <div id="errorContent">
                        <div class="error-message" id="error-postal"></div>
                    </div>
                </div>
            </div>
    
            <div class="form-group">
                <label for="nova_capacitat" class="form-label">Aforo</label>
                <input type="number" class="form-controller" id="nova_capacitat" name="nova_capacitat"
                    value="<?php echo e(old('nova_capacitat')); ?>">
                <div id="errorDivcapacitat" class="errorDiv" style="display: none;">
                    <div id="errorContent">
                        <div class="error-message" id="error-capacitat"></div>
                    </div>
                </div>
            </div>
            <div id="errorDiv" class="errorDiv" style="display: none;">
                <div id="errorContent">
                    <div class="error-message" id="error-message"></div>
                </div>
            </div>
            <input type="hidden" name="nova_user_id" value="<?php echo e(session('user_id')); ?>">
            <button type="submit" id="addAddress" class="btn btn-blue">Añadir nueva dirección</button>
    
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
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
        function validarCamposVacios() {
            if (nousCamps.style.display === 'block') {
                var novaNom = document.getElementById('nova_nom').value.trim();
                var novaProvincia = document.getElementById('nova_provincia').value.trim();
                var novaCiutat = document.getElementById('nova_ciutat').value.trim();
                var novaCodiPostal = document.getElementById('nova_codi_postal').value.trim();
                var novaCapacitat = document.getElementById('nova_capacitat').value.trim();

                // Validar que el código postal sea numérico
                if (isNaN(novaCodiPostal)) {
                    mostrarMissatge('postal', 'El código postal debe ser un valor numérico.');
                    return false;
                } else {
                    ocultarMissatge('postal');
                }

                // Validar que la capacidad sea numérica
                if (isNaN(novaCapacitat)) {
                    mostrarMissatge('capacitat', 'El aforo debe ser un valor numérico.');
                    return false;
                } else {
                    ocultarMissatge('capacitat');
                }

                if (novaNom === '') {
                    mostrarMissatge('nomLocal', 'Introduce el nombre del local.');
                    return false;
                } else {
                    ocultarMissatge('nomLocal');
                }

                if (novaProvincia === '') {
                    mostrarMissatge('provincia', 'Debes incluir la provincia del recinto.');
                    return false;
                } else {
                    ocultarMissatge('provincia');
                }

                if (novaCiutat === '') {
                    mostrarMissatge('ciutat', 'Debes introducir la ciudad del recinto.');
                    return false;
                } else {
                    ocultarMissatge('ciutat');
                }

                if (novaCodiPostal === '') {
                    mostrarMissatge('postal', 'El codigo postal es un campo obligatorio.');
                    return false;
                } else {
                    ocultarMissatge('postal');
                }

                if (novaCapacitat === '') {
                    mostrarMissatge('capacitat', 'Debes indicar la capacidad del recinto.');
                    return false;
                } else {
                    ocultarMissatge('capacitat');
                }
            }
            // Validar que el código postal tenga el formato adecuado (5 dígitos)
            var codiPostalRegExp = /^\d{5}$/;
            if (!codiPostalRegExp.test(novaCodiPostal)) {
                mostrarMissatge('postal', 'El código postal debe tener 5 dígitos.');
                return false;
            } else {
                ocultarMissatge('postal');
            }

            return true;
        }
        document.querySelector('#addAddress').addEventListener('click', function(e){
            e.preventDefault();
            if (validarCamposVacios()) {
                document.getElementById('nousCamps').submit();
            }
        }) 
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\domin\Escritorio\gr6-arrua-galindo-jumelle\site\resources\views/crearRecinte.blade.php ENDPATH**/ ?>