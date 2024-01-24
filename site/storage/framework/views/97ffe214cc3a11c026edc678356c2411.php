<?php $__env->startSection('title', 'Detalles del Evento'); ?>

<?php $__env->startSection('content'); ?>
    <div class="containerEvent">
        
        <div class="textEvent">
            <h1><?php echo e($esdeveniment->nom); ?></h1>
            <h6><?php echo e($esdeveniment->descripcio); ?></h6>
            <form action="<?php echo e(route('detallesLocal', ['id' => $esdeveniment->id])); ?>" method="get" class="detallesLocal"
                id="detallesLocal">
                <p><strong>Local:</strong> <?php echo e($esdeveniment->recinte->lloc); ?><button tipe="submit">Ver Local</button></p>
            </form>

            <form action="<?php echo e(route('confirmacioCompra')); ?>" method="post" class="ComprarEntrada" id="ComprarEntrada"
                enctype="multipart/form-data"name="a">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label for="fecha" class="form-label">Sesiones:</label>
                    <select class="form-select" id="fecha" name="fecha" required>
                      <option value="" disabled selected>Fechas de las sesiones</option>
                        <?php $__currentLoopData = $fechas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fecha): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($fecha->data); ?>,<?php echo e($fecha->id); ?>"><?php echo e($fecha->data); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="form-group" id="entradas" style="display:none;">
                  <label for="preu" class="form-label">Tipus Entradas:</label>
                  <select class="form-select" id="preu" name="preu" required>
                    <option value="" disabled selected>Entradas</option>
                      <?php $__currentLoopData = $entradas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entrada): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($entrada->preu); ?>,<?php echo e($entrada->quantitat); ?>,<?php echo e($entrada->nom); ?>,<?php echo e($entrada->id); ?>" ><?php echo e($entrada->nom); ?> <?php echo e($entrada->preu); ?>€ </option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                  <label for="cantidad" class="form-label" id="escogerCantidad">Escoge el numero de entradas:</label>
                  
                  <div class="form-group" id="errorCantidad" style="display:none;">
                    <p id="mensajeError" class="errorMsg"></p>
                  </div>
                  <input type="number" id="cantidad" name="cantidad" min="1" max="2" />
                  <button type="button" id="reservarEntrada">Reservar entrada</button>
                 
                  <div class="form-group" id="listaEntradas" style="display:none;">
                    <label for="cantidad" class="form-label">Entradas Reservadas:</label>
                    <div id="containerList">
                      
                    </div>
                  </div>

              </div>
                <div class="form-group">
                    <label for="Preutotal" class="form-label"id="precioTotal">Total:<?php echo e($preuTotal); ?> </label>
                </div>
                <button type="submit">Comprar</button>
            </form>

        </div>
        <div class="imagenesEventos">
            <img src="<?php echo e(Storage::url($esdeveniment->imatge)); ?>" alt="Imatge de l'esdeveniment" class="event-imagen">
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('js/esdeveniment.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\domin\Escritorio\gr6-arrua-galindo-jumelle\site\resources\views/esdeveniment.blade.php ENDPATH**/ ?>