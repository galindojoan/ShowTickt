<?php $__env->startSection('title', 'Detalles del Evento'); ?>

<?php $__env->startSection('content'); ?>
    <div class="containerEvent">
        
        <div class="textEvent">
            <h1><?php echo e($esdeveniment->nom); ?></h1>
            <h6><?php echo e($esdeveniment->descripcio); ?></h6>
            <form action="<?php echo e(route('detallesLocal', ['id' => $esdeveniment->id])); ?>" method="get" class="detallesLocal"
                id="detallesLocal">
                <p><strong>Local:</strong> <?php echo e($esdeveniment->recinte->lloc); ?><button type="submit">Ver Local</button></p>
            </form>

            <form action="<?php echo e(route('confirmacioCompra')); ?>" method="post" class="ComprarEntrada" id="ComprarEntrada"
                enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <label for="session" class="form-label">Sesiones:</label>
                <?php if(count($fechas) == 1): ?>
                    <div class="form-group">

                        <?php $__currentLoopData = $fechas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fecha): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <p><?php echo e($fecha->data); ?></p>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div id="calendar"></div>
                <?php endif; ?>

                <div class="form-group" id="entradas" style="display:none;">
                    <label id="preu" class="form-label">Tipus Entradas:</label>

                    <?php $__currentLoopData = $fechas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fecha): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <select class="form-select" id="<?php echo e($fecha->id); ?>" name="preu" style="display:none;">
                            <option value="" disabled selected>Entradas</option>
                            <?php $__currentLoopData = $entradas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entrada): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($entrada->sessios_id == $fecha->id): ?>
                                    <option
                                        value="<?php echo e($entrada->preu); ?>,<?php echo e($entrada->quantitat); ?>,<?php echo e($entrada->nom); ?>,<?php echo e($entrada->id); ?>">
                                        <?php echo e($entrada->nom); ?> <?php echo e($entrada->preu); ?>€ </option>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <label for="cantidad" class="form-label" id="escogerCantidad">Escoge la entrada y el numero de
                        entradas:</label>

                    <div class="form-group" id="errorCantidad" style="display:none;">
                        <p id="mensajeError" class="errorMsg"></p>
                    </div>
                    <input type="number" id="cantidad" name="cantidad" min="1" max="10" value="2" />
                    <button type="button" id="reservarEntrada">Reservar entrada</button>

                    <div class="form-group" id="listaEntradas" style="display:none;">
                        <label for="cantidad" class="form-label">Entradas Reservadas:</label>
                        <div id="containerList">
                        </div>
                    </div>

                </div>
                <div class="form-group">
                    <label id="Preutotal" class="form-label">Total:<?php echo e($preuTotal); ?> </label>
                </div>
                <input type="hidden" id="arrayEntradas">
                <button type="submit">Comprar</button>
            </form>

        </div>
        <div class="imagenesEventos">
            <img src="<?php echo e(Storage::url($esdeveniment->imatge)); ?>" alt="Imatge de l'esdeveniment" class="event-imagen">
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('js/esdeveniment.js')); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script>
        const fechasSessiones = <?php echo json_encode($fechas, 15, 512) ?>;
        // Ordenar el array utilizando la función de comparación
        fechasSessiones.sort(compararFechas);
            document.addEventListener('DOMContentLoaded', function() {
                let buenas;
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next',
                        center: 'title',
                        right: 'dayGridMonth,dayGridWeek'
                    },
                    selectable: true,
                    events: crearEventos(fechasSessiones),
                    eventClick: function(event) {
                        let sessionId=event.event.title.split(" ");
                        sessionSelect(fechasSessiones[(parseInt(sessionId[0])-1)]);
                    }
                });
                calendar.render();
            });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\domin\Escritorio\gr6-arrua-galindo-jumelle\site\resources\views/esdeveniment.blade.php ENDPATH**/ ?>