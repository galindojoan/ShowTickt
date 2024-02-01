<!doctype html>
<html lang="ca"> 

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="<?php echo e(asset('imagen/logo-definitivo.ico')); ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>"> 
    <title><?php echo $__env->yieldContent('title'); ?></title>
</head>

<body class="w3-content">
  <header>
    <a href="<?php echo e(route('home')); ?>"><img class="logo" alt="logoShowTickt" src="<?php echo e(asset('imagen/logo-definitivo.png')); ?>"></a>
    <h1 class="titulo">ShowTickt</h1>


    <?php if(session('key')): ?>
    <button id="openOpt" class="selOpt ahref"><?php echo e(session('key')); ?></button>
    <div id="opciones">
      <form action="<?php echo e(route('session')); ?>" method="get" id="form">
        <button id="profile" class="optionProfile">Perfil</button>
        <button id="sesion" class="optionProfile">Salir</button>
        <input type="hidden" name="sesionOpcion" id="sesionOpcion">
      </form>
    </div>    
    <?php else: ?>
    <form  action="<?php echo e(route('session')); ?>" method="post" id="form">
      <?php echo csrf_field(); ?>
      <button id="iniciar" class="selOpt ahref">Iniciar Sesión</button>
      <input type="hidden" name="sesionOpcion" id="iniciarSesion" value="openSession">
    </form>
   
    <?php endif; ?>
  </header>
  <div class="masterBody">
    <?php echo $__env->yieldContent('content'); ?> 
  </div>
  <footer>
    <a id="footerHome" href="<?php echo e(route('home')); ?>">HOME</a>
    <form method="POST" action="<?php if(session('key')): ?>
    <?php echo e(route('homePromotor')); ?>

    <?php else: ?><?php echo e(route('login')); ?>

    <?php endif; ?>">
    <?php echo csrf_field(); ?>
      <input class="ahref" type="submit" value="PROMOTORES">
    </form>
  </footer>
  <script>
    const options = document.getElementById('opciones');
    const profileOption = document.querySelector('#profile');
    const sessionOption = document.querySelector('#sesion');
    const form = document.querySelector('#form');
    const iniciar = document.querySelector('#iniciar');
    let hiddenInp = document.querySelector('#sesionOpcion');

    options.style.display = 'none';
    const button = document.querySelector('.selOpt');
    window.addEventListener('click',function(e){
      if(button.contains(e.target)){
        button.style.display = 'none';
        options.style.display = 'block';
      }else{
        button.style.display = 'block';
        options.style.display = 'none';
      }
    })
    profileOption.addEventListener('click',function(e){
      e.preventDefault();
      hiddenInp.value = 'profile';
      form.submit();

    });
    sessionOption.addEventListener('click',function(e){
      e.preventDefault();
      hiddenInp.value = 'closeSession';
      form.submit();
    });
    iniciar.addEventListener('click', function(e){
      e.preventDefault();
      document.querySelector('#iniciarSesion').value = 'openSession';
      form.submit();
    })
  </script>
  <?php echo $__env->yieldContent('scripts'); ?>
</body>

</html><?php /**PATH C:\Users\jumel\OneDrive\Escritorio\gr6-arrua-galindo-jumelle\site\resources\views/layouts/master.blade.php ENDPATH**/ ?>