

<?php $__env->startSection('title', 'resultados'); ?>

<?php $__env->startSection('content'); ?>
    <?php if($esdeveniments->isEmpty()): ?>
        <div class="center-message">
            <p class="info-alert">No se ha encontrado ningún evento.</p>
        </div>
    <?php else: ?>
        <div class="info-message">
            <p class="info-text">Haz clic sobre un evento para poder editarlo.</p>
        </div>

        <div class="event-cards">
            <?php $__currentLoopData = $esdeveniments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $esdeveniment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('editar-esdeveniment', ['id' => $esdeveniment->id])); ?>" class="event-link">
                    <div class="event-card">
                        <div class="event-details">
                            <h1><?php echo e($esdeveniment->nom); ?> </h1>
                            <?php if($esdeveniment->sesions->isNotEmpty() && $esdeveniment->sesions->first()->data !== null): ?>
                                <h3><?php echo e($esdeveniment->sesions->first()->data); ?></h3>
                            <?php else: ?>
                                <h3>No hay sesiones</h3>
                            <?php endif; ?>
                            <h4><?php echo e($esdeveniment->recinte->lloc); ?></h4>
                            <?php if($esdeveniment->sesions->isNotEmpty() && $esdeveniment->sesions->first()->entrades->isNotEmpty()): ?>
                                <h2><?php echo e($esdeveniment->sesions->first()->entrades->first()->preu); ?> €</h2>
                            <?php else: ?>
                                <h2>Sin entradas</h2>
                            <?php endif; ?>
                        </div>
                        <img src="<?php echo e(Storage::url($esdeveniment->imatge)); ?>" alt="Imatge de l'esdeveniment">
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="pages"><?php echo e($esdeveniments->links('pagination::bootstrap-5')); ?></div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\alexg\OneDrive\Documentos\Projecte 2\gr6-arrua-galindo-jumelle\site\resources\views/administrarEsdeveniments.blade.php ENDPATH**/ ?>