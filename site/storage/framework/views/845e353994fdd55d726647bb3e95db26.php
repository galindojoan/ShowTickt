

<?php $__env->startSection('title', 'Cambiar contraseña'); ?>

<?php $__env->startSection('content'); ?>
<div class="loginPage">
    <div class="login">
        <h2>Cambiar Contraseña</h2>
        <?php if($errors->has('error')): ?>
            <span class="errorMsg"><?php echo e($errors->first('error')); ?></span>
        <?php endif; ?>
        <form action="<?php echo e(route('peticionCambiar')); ?>" method="post" id="loginForm">
        <?php echo csrf_field(); ?>
            <div class="loginInput">
                <input type="hidden" name="userId" value="<?php echo e($_GET['user']); ?>">
                <input type="password" name="password" id="password" placeholder="Nueva contraseña" required>
            </div>
            <input type="submit" value="Cambiar" class="boton">
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\jumel\OneDrive\Escritorio\gr6-arrua-galindo-jumelle\site\resources\views/cambiarPassword.blade.php ENDPATH**/ ?>