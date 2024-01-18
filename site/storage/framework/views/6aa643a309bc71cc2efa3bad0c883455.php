<?php $__env->startSection('title', 'Editar Evento'); ?>

<?php $__env->startSection('content'); ?>
    <div class="containerEvent">
        <div class="textEvent">
            <h1><?php echo e($esdeveniment->nom); ?></h1>
            <p>Fecha: <?php echo e($esdeveniment->dia); ?></p>
            <p>Lugar: <?php echo e($esdeveniment->recinte->lloc); ?></p>
            <!-- Otros detalles del evento -->
        </div>
        <div class="imagenesEventos">
            <img src="<?php echo e(Storage::url( $esdeveniment->imatge )); ?>" alt="Imatge de l'esdeveniment">
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\domin\Escritorio\gr6-arrua-galindo-jumelle\site\resources\views/editarEsdeveniment.blade.php ENDPATH**/ ?>