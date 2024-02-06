

<?php $__env->startSection('title', 'Confirmar compra'); ?>

<?php $__env->startSection('content'); ?>
    <div id="content-container">
        <center>
            <h1>Resumen De la Compra:</h1>
        </center>
        <div class="resumenCompra">
            <h5>Evento: <?php echo e($nomEvent); ?></h5>
            <p id="fecha">Fecha:</p>
            <p id="hora">Horas:</p>
            <div class="ticketCompra">
                <p>Nombre</p>
                <p>cantidad</p>
                <p>Precio</p>
                <p>Total</p>
            </div>
            <?php $__currentLoopData = $entradaArray; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entrada): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="ticketCompra">
                    <p><?php echo e($entrada->nom); ?></p>
                    <p><?php echo e($entrada->cantidad); ?></p>
                    <p><?php echo e($entrada->precio); ?>€</p>
                    <p><?php echo e($entrada->precio * $entrada->cantidad); ?>€</p>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <p id="total">Total: <?php echo e($total); ?>€</p>
        </div>
        <form action="<?php echo e(route('confirmacioCompra')); ?>" method="post" class="addEvent" id="ComprarEntrada">
            <div class="form-group" id="error" style="display:none;">
                <p id="mensajeError" class="msg-error"></p>
            </div>
            <?php if($sessionArray->nominal == true): ?>
                <?php $__currentLoopData = $entradaArray; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entrada): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo e($entrada->nom); ?>

                    <?php for($i = 1; $i <= $entrada->cantidad; $i++): ?>
                        <div class="form-group" id="divNominal">
                            <label for="nova_carrer" class="form-label">Nom</label>
                            <input type="text" class="form-controller" id="NomComprador" name="NomComprador">
                            <label for="nova_carrer" class="form-label">DNI</label>
                            <input type="text" class="form-controller" id="DNIComprador" name="DNIComprador">
                            <label for="nova_carrer" class="form-label">Telefon</label>
                            <input type="number" class="form-controller" id="telefonComprador" name="telefonComprador">
                        </div>
                    <?php endfor; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="form-group">
                    <label for="nova_carrer" class="form-label">Nom</label>
                    <input type="text" class="form-controller" id="NomComprador" name="NomComprador">
                    <label for="nova_carrer" class="form-label">DNI</label>
                    <input type="text" class="form-controller" id="DNIComprador" name="DNIComprador">
                    <label for="nova_carrer" class="form-label">Telefon</label>
                    <input type="tel" class="form-controller" id="telefonComprador" name="telefonComprador">
                </div>
            <?php endif; ?>
            <div class="form-group">
                <label for="email" class="form-label">Mail:</label>
                <input type="email" class="form-controller" id="email" name="email">
            </div>

            <button type="button" id="bottonCompra" class="btn btn-blue">Finalizar Compra</button>
        </form>
    </div>

    <form action="<?php echo e(route('mostrar-esdeveniment', ['id' => $sessionArray->esdeveniments_id])); ?>" id="vueltaAtras">

    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        let esError = true;
        const verFecha = document.getElementById("fecha");
        const verHora = document.getElementById("hora");
        const MasAsistents = document.getElementById("añadirAsistente");
        const divNominal = document.getElementById("divNominal");
        const divError = document.getElementById("error");
        const mensajeError = document.getElementById("mensajeError");
        const comprar = document.getElementById("bottonCompra");
        const sessionArray = <?php echo json_encode($sessionArray, 15, 512) ?>;
        const entradaArray = <?php echo json_encode($entradaArray, 15, 512) ?>;

        function ErroresdelTelefono() {
            document.querySelectorAll('#telefonComprador').forEach(element => {
                element.addEventListener('keyup', function() {
                    var telefonoInput = this.value;
                    if (!/^\d+$/.test(telefonoInput)) {
                        mensajeError.textContent =
                            'El número de teléfono solo puede contener dígitos numéricos.';
                        divError.style.display = "block";
                        esError = true;
                        setTimeout(function() {
                            divError.style.display = "none";
                        }, 3000);
                    } else if (telefonoInput.length > 9) {
                        mensajeError.textContent =
                            'El número de teléfono no puede tener más de 10 dígitos.';
                        divError.style.display = "block";
                        setTimeout(function() {
                            divError.style.display = "none";
                        }, 3000);
                        esError = true;
                    } else {
                        esError = false;
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
            if (esError) {
                mensajeError.textContent = 'El número de teléfono tiene Errores O no esta';
                divError.style.display = "block";
                setTimeout(function() {
                    divError.style.display = "none";
                }, 3000);
            } else {
                document.getElementById("ComprarEntrada").submit();
            }
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\domin\Escritorio\gr6-arrua-galindo-jumelle\site\resources\views/confirmarCompra.blade.php ENDPATH**/ ?>