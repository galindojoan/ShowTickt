<?php $__env->startSection('title', 'resultados'); ?>

<?php $__env->startSection('content'); ?>
    <div class="event-cards">
        <?php $__currentLoopData = $esdeveniments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $esdeveniment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('editar-esdeveniment', ['id' => $esdeveniment->id])); ?>" class="event-link">
                <div class="event-card">
                    <div class="event-details">
                        <p><?php echo e($esdeveniment->nom); ?>  </p>
                        <p><?php echo e($esdeveniment->categoria->tipus); ?></p>
                        <p><?php echo e($esdeveniment->recinte->lloc); ?></p>
                    </div>
                    <img src="<?php echo e(Storage::url( $esdeveniment->imatge )); ?>" alt="Imatge de l'esdeveniment">
                </div>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="pages"><?php echo e($esdeveniments->links('pagination::bootstrap-5')); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\domin\Escritorio\gr6-arrua-galindo-jumelle\site\resources\views/administrarEsdeveniments.blade.php ENDPATH**/ ?>