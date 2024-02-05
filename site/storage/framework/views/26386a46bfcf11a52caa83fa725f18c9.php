

<?php $__env->startSection('title', 'Confirmar compra'); ?>

<?php $__env->startSection('content'); ?>
    <h1><?php echo e($nomEvent); ?></h1>
    <?php echo e($sessionArray); ?>

    <h5>Resumen De la Compra:</h5>
    <div id="resumenCompra">
        <p id="fecha">Fecha:</p>
        <p id="hora">Horas:</p>
        <div id="resumPrecio" class="ticketCompra">
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
        
    </div>
    <p id="hora">Total: <?php echo e($total); ?>€</p>
    </div>
    <form action="<?php echo e(route('confirmacioCompra')); ?>" method="post" class="ComprarEntrada" id="ComprarEntrada">
        <?php if(1 == 2): ?>
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
        <?php else: ?>
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
        <?php endif; ?>
        <div class="form-group">
          <label for="email" class="form-label">Mail:</label>
          <input type="email" class="form-controller" id="email" name="email">
      </div>
      
        <button type="submit" id="bottonCompra">Finalizar Compra</button>
    </form>
    
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        const verFecha = document.getElementById("fecha");
        const verHora = document.getElementById("hora");
        const sessionArray = <?php echo json_encode($sessionArray, 15, 512) ?>;
        const entradaArray = <?php echo json_encode($entradaArray, 15, 512) ?>;

        setTimeout(function () {
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
        verFecha.textContent = `Fecha: ${fecha(sessionArray[0].data)}`;
        verHora.textContent = `Hora: ${hora(sessionArray[0].data)}`;

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\domin\Escritorio\gr6-arrua-galindo-jumelle\site\resources\views/confirmarCompra.blade.php ENDPATH**/ ?>