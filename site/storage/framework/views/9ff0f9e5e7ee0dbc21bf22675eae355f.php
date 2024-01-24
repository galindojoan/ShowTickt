<?php $__env->startSection('title', 'Editar Evento'); ?>

<?php $__env->startSection('content'); ?>
    <div class="containerEvent">
        <div class="textEvent">
            <h1><?php echo e($esdeveniment->nom); ?></h1>
            <button id="fechaButton">Fechas:
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="10"
                    width="10"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                    <path
                        d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z" />
                </svg>
            </button>
            <div class="form-select" id="fechaDiv" name="fecha" style="display: none;">
                <button id="exit"><svg xmlns="http://www.w3.org/2000/svg" height="14" width="10.5"
                        viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <path
                            d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                    </svg></button>
                <?php $__currentLoopData = $fechas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fecha): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <form action="<?php echo e(route('editarSesion')); ?>" method="GET" class="fecha">
                        <input type="hidden" name="eventoId" value="<?php echo e($esdeveniment->id); ?>">
                        <input type="hidden" name="fechaId" value="<?php echo e($fecha->id); ?>">
                        <p value="<?php echo e($fecha->id); ?>"><?php echo e($fecha->data); ?></p>
                        <button type="submit"><svg xmlns="http://www.w3.org/2000/svg" height="14" width="14" viewBox="0 0 512 512">
                                <path
                                    d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
                            </svg></button>
                    </form>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <form method="get" action="<?php echo e(route('añadirSession')); ?>">
                <input type="hidden" name="event-id" value="<?php echo e($esdeveniment->id); ?>">
                <button type="submit" class="boton">Añadir Sesión</button>
            </form>
            <p>Lugar: <?php echo e($esdeveniment->recinte->lloc); ?></p>
            <!-- Otros detalles del evento -->
        </div>
        <div class="imagenesEventos">
            <img src="<?php echo e(Storage::url($esdeveniment->imatge)); ?>" alt="Imatge de l'esdeveniment" class="event-imagen">
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        const fechasDiv = document.querySelector('#fechaDiv');
        const buttonFechas = document.querySelector('#fechaButton');
        const exit = document.querySelector('#exit');
        buttonFechas.addEventListener('click', function(e) {
            fechasDiv.style.display = 'grid';
            buttonFechas.style.display = 'none';

        })
        exit.addEventListener('click', function(e) {
            fechasDiv.style.display = 'none';
            buttonFechas.style.display = 'block';
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\jumel\OneDrive\Escritorio\gr6-arrua-galindo-jumelle\site\resources\views/editarEsdeveniment.blade.php ENDPATH**/ ?>