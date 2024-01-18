<?php $__env->startSection('title', 'Login'); ?>

<?php $__env->startSection('content'); ?>
<div class="loginPage">
    <div class="login">
        <h2>Login</h2>
        <?php if($errors->has('msg')): ?>
            <span class="errorMsg">Usuario o contraseña incorrecta</span>
        <?php endif; ?>
        <form action="<?php echo e(route('homePromotor')); ?>" method="post" id="loginForm">
        <?php echo csrf_field(); ?>
            <div class="loginInput">
                <input type="text" name="usuario" id="usuario" placeholder="Usuario" required>
                <input type="password" name="password" id="password" placeholder="Contraseña" required>
                <a href="recuperar">Contraseña olvidada?</a>
            </div>
            <input type="submit" value="Acceder" class="boton">
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\domin\Escritorio\gr6-arrua-galindo-jumelle\site\resources\views/login.blade.php ENDPATH**/ ?>