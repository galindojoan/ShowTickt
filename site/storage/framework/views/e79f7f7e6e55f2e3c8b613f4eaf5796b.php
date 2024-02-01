<?php $__env->startSection('title', 'Home'); ?>

<?php $__env->startSection('content'); ?>

        <div class="bg">
            <?php if(session('key')): ?>
                <div class="button-container">
                    <a href="<?php echo e(route('administrar-esdeveniments')); ?>" class="custom-button">Administrar Esdeveniments</a>
                    <a href="<?php echo e(route('llistat-sessions' )); ?>" class="custom-button">Llistat de sessions</a>
                    <a href="<?php echo e(route('crear-esdeveniment')); ?>" class="custom-button">Crear Esdeveniment</a>
                </div>
            <?php endif; ?>
        </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\alexg\OneDrive\Documentos\Projecte 2\gr6-arrua-galindo-jumelle\site\resources\views/homePromotor.blade.php ENDPATH**/ ?>