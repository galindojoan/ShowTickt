<?php $__env->startSection('title', 'Detalles del Evento'); ?>

<?php $__env->startSection('content'); ?>
    <div class="containerEvent">
      <div class="textEvent">
        <h1><?php echo e($esdeveniment->nom); ?></h1>
        <p>Fecha: <?php echo e($esdeveniment->dia); ?></p>
        <p>Lugar: <?php echo e($esdeveniment->recinte->lloc); ?></p>
        <p>Precio: <?php echo e($esdeveniment->preu); ?> €</p>
        <!-- Otros detalles del evento -->
      </div>
      <div class="imagenesEventos">
        <img id="imagenEvento"src="<?php echo e($esdeveniment->imatge); ?>">
      </div>
    </div>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\jumel\OneDrive\Escritorio\gr6-arrua-galindo-jumelle\site\resources\views/esdeveniment.blade.php ENDPATH**/ ?>