<?php $__env->startSection('title', 'Login'); ?>

<?php $__env->startSection('content'); ?>
<div class="login">
    <?php if($errors->has('error')): ?>
        <span class="msg-error"><?php echo e($errors->first('error')); ?></span>
    <?php elseif($errors->has('vali')): ?>
        <span class="msg-valido"><?php echo e($errors->first('vali')); ?></span>
    <?php endif; ?>
    <div class="login-div">
        <h2>Login</h2>
        <form action="<?php echo e(route('homePromotor')); ?>" method="post" id="loginForm" class="login-form">
        <?php echo csrf_field(); ?>
            <div class="login-input">
                <input type="text" name="usuario" id="usuario" placeholder="Usuario" required>
                <input type="password" name="password" id="password" placeholder="Contraseña" required>
                <a href="recuperar">Contraseña olvidada?</a>
            </div>
            <input type="submit" value="Acceder" class="boton">
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\alexg\OneDrive\Documentos\Projecte 2\gr6-arrua-galindo-jumelle\site\resources\views/login.blade.php ENDPATH**/ ?>