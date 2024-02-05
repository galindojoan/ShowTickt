<!-- resources/views/components/event-card.blade.php -->

<div class="event-card">
    <div class="event-details">
        <h1><?php echo e($esdeveniment->nom); ?></h1>
        <?php if($esdeveniment->sesions->isNotEmpty() && $esdeveniment->sesions->first()->data !== null): ?>
            <h3><?php echo e($esdeveniment->sesions->first()->data); ?></h3>
        <?php else: ?>
            <h3>No hay sesiones</h3>
        <?php endif; ?>
        <h4><?php echo e($esdeveniment->recinte->lloc); ?></h4>
        <?php if($esdeveniment->sesions->isNotEmpty() && $esdeveniment->sesions->first()->entrades->isNotEmpty()): ?>
            <h2><?php echo e($esdeveniment->sesions->first()->entrades->first()->preu); ?> €</h2>
        <?php else: ?>
            <h2>Entradas Agotadas</h2>
        <?php endif; ?>
    </div>
    <img src="<?php echo e(Storage::url($esdeveniment->imatge)); ?>" alt="Imatge de l'esdeveniment">
</div>
<?php /**PATH C:\Users\alexg\OneDrive\Documentos\Projecte 2\gr6-arrua-galindo-jumelle\site\resources\views/components/event-card.blade.php ENDPATH**/ ?>