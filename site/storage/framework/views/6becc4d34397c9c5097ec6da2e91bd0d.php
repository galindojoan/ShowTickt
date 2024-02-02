<?php $__env->startSection('title', 'Recuperar'); ?>

<?php $__env->startSection('content'); ?>
<div class="login">
    <?php if($errors->has('error')): ?>
        <span class="msg-error"><?php echo e($errors->first('error')); ?></span>
    <?php endif; ?>
    <div class="login-div">
        <h2>Contraseña Olvidada</h2>
        <span id="indicador">Escriba la cuenta a recuperar.</span> <br> <br>
        <form action="<?php echo e(route('recuperar-form')); ?>" method="post" id="recuperarForm" >
        <?php echo csrf_field(); ?>
            <div class="login-input">
                <input type="email" name="email" id="email" placeholder="Email">
            </div>
            <div>
                <a href="<?php echo e(route('login')); ?>" class="boton" id="atras">Atrás</a>
                <input type="submit" value="Enviar" class="boton">
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\alexg\OneDrive\Documentos\Projecte 2\gr6-arrua-galindo-jumelle\site\resources\views/recuperar.blade.php ENDPATH**/ ?>