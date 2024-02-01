<?php $__env->startSection('title', 'Home'); ?>

<?php $__env->startSection('content'); ?>
    <?php if($events->isEmpty()): ?>
        <div class="center-message">
            <p class="info-alert">No se ha encontrado ningún evento.</p>
        </div>
    <?php else: ?>
        <div class="container">
            <form action="<?php echo e(route('cerca')); ?>" method="get" class="form form-filtre" id="filtre">
                <div class="input-group">
                    <select name="category" class="form-control" onchange="this.form.submit()">
                        <option value="" disabled selected>Categorías</option>
                        <option value="" <?php echo e($categoryId === null ? 'selected' : ''); ?>>Mostrar todos</option>
                        <?php $__currentLoopData = $categoriesWithEventCount; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>" <?php echo e($categoryId == $category->id ? 'selected' : ''); ?>>
                                <?php echo e($category->tipus); ?> (<?php echo e($category->eventCount); ?> eventos)
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <div class="icon-container">
                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14"
                            viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                            <path
                                d="M201.4 342.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 274.7 86.6 137.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z" />
                        </svg>
                    </div>
                </div>
            </form>



            <!-- Formulario de búsqueda -->
            <form action="<?php echo e(route('cerca')); ?>" method="get" class="form form-cerca" id="cerca">
                <div class="input-group">
                    <!-- Campo de entrada oculto para la categoría -->
                    <input type="hidden" name="category" value="<?php echo e($categoryId); ?>">
                    <input type="text" name="q" class="form-control" placeholder="Buscar">
                    <button type="submit" class="btn-primary"><svg xmlns="http://www.w3.org/2000/svg" height="16"
                            width="16"
                            viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                            <path fill="#1e91d9"
                                d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" />
                        </svg></button>
                </div>
            </form>
            <form id="promotores" class="form form-promotores" method="POST"
                action="<?php if(session('key')): ?> <?php echo e(route('homePromotor')); ?>

            <?php else: ?><?php echo e(route('login')); ?> <?php endif; ?>">
                <?php echo csrf_field(); ?>
                <input class="linkPromotor" type="submit" value="PROMOTORES">
            </form>
        </div>



        <?php $__currentLoopData = $categoriesWith3; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="event-home">
                <h2><?php echo e($category->tipus); ?></h2>
                <?php
                    $cont = 0;
                ?>
                <?php $__currentLoopData = $esdeveniments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $esdeveniment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($esdeveniment->categoria_id == $category->id && $cont < 3): ?>
                        <?php
                            $cont++;
                        ?>
                        <a href="<?php echo e(route('mostrar-esdeveniment', ['id' => $esdeveniment->id])); ?>" class="event-link">
                            <div class="event-card">
                                <div class="event-details">
                                    <p><?php echo e($esdeveniment->nom); ?></p>
                                    <?php if($esdeveniment->sesions->isNotEmpty() && $esdeveniment->sesions->first()->data !== null): ?>
                                        <p><?php echo e($esdeveniment->sesions->first()->data); ?></p>
                                    <?php else: ?>
                                    <p>No hay sesiones</p>
                                    <?php endif; ?>
                                        <p><?php echo e($esdeveniment->recinte->lloc); ?></p>
                                        <?php if($esdeveniment->sesions->isNotEmpty() && $esdeveniment->sesions->first()->entrades->isNotEmpty()): ?>
                                            <p><?php echo e($esdeveniment->sesions->first()->entrades->first()->preu); ?> €</p>
                                        <?php else: ?>
                                        <p>Entradas Agotadas</p>
                                        <?php endif; ?>
                                </div>
                                <img src="<?php echo e(Storage::url($esdeveniment->imatge)); ?>" alt="Imatge de l'esdeveniment">
                            </div>
                        </a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <form action="<?php echo e(route('cerca')); ?>" method="get" class="event-form">
                    <div class="event-group">
                        <input type="hidden" name="category" value="<?php echo e($category->id); ?>">
                        <button type="submit" class="event-btn">ver mas ></button>
                    </div>
                </form>

            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\domin\Escritorio\gr6-arrua-galindo-jumelle\site\resources\views/home.blade.php ENDPATH**/ ?>