<?php $__env->startSection('title', 'Detalles del Evento'); ?>

<?php $__env->startSection('content'); ?>
    <div class="containerEvent">
      
      <div class="textEvent">
        <h1><?php echo e($esdeveniment->nom); ?></h1>
        <h6><?php echo e($esdeveniment->descripcio); ?></h6>
        <p><strong>Lugar:</strong> <?php echo e($esdeveniment->recinte->lloc); ?></p>
        <form action="<?php echo e(route('confirmacioCompra')); ?>" method="post" class="ComprarEntrada" id="ComprarEntrada"
            enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="form-group">
              <label for="fecha" class="form-label">Fechas:</label>
              <select class="form-select" id="fecha" name="fecha" required>
                  <?php $__currentLoopData = $fechas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fecha): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($fecha->id); ?>"><?php echo e($fecha->data_sessio); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
          </div>
          <div class="form-group">
            <label for="preu" class="form-label">Tipus Entradas</label>
            <select class="form-select" id="preu" name="preu" required>
                <?php $__currentLoopData = $entradas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entrada): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($entrada->id); ?>"><?php echo e($entrada->nom); ?> <?php echo e($entrada->preu); ?>€ </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
          <div class="form-group">
            <label for="Preutotal" class="form-label">Total:<?php echo e($preuTotal); ?> </label>
        </div>
            <button tipe="submit">Comprar</button>
        </form>
        
      </div>
      <div class="imagenesEventos">
        <img src="<?php echo e(Storage::url( $esdeveniment->imatge )); ?>" alt="Imatge de l'esdeveniment" class="event-imagen">
      </div>
      
    </div>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\domin\Escritorio\gr6-arrua-galindo-jumelle\site\resources\views/esdeveniment.blade.php ENDPATH**/ ?>