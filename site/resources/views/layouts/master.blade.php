<!doctype html>
<html lang="ca"> 

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('imagen/logo-definitivo.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
    <title>@yield('title')</title>
</head>

<body class="w3-content">
  <header>
    <img class="logo" alt="logoShowTickt" src="{{ asset('imagen/logo-definitivo.png') }}">
    <h1 class="titulo">ShowTickt</h1>


    @if(session('key'))
    <button id="openOpt" class="selOpt ahref">{{ session('key') }}</button>
    <div name="opciones">
      <form action="{{route('session')}}" method="get" id="form">
        <button id="profile" class="optionProfile">Perfil</button>
        <button id="sesion" class="optionProfile">Salir</button>
        <input type="hidden" name="sesionOpcion" id="sesionOpcion">
      </form>
    </div>    
    @else
    <form  action="{{route('session')}}" method="post" id="form">
      @csrf
      <button id="iniciar" class="selOpt ahref">Iniciar Sesión</button>
      <input type="hidden" name="sesionOpcion" id="iniciarSesion" value="openSession">
    </form>
   
    @endif
  </header>
  <div>
    @yield('content') 
  </div>
  <footer>
    <a id="footerHome" href="{{ route('home') }}">HOME</a>
    <form method="POST" action="@if(session('key'))
    {{route('homePromotor')}}
    @else{{route('login')}}
    @endif">
    @csrf
      <input class="ahref" type="submit" value="PROMOTORES">
    </form>
  </footer>
  <script>
    const options = document.querySelector('div[name="opciones"]');
    const profileOption = document.querySelector('#profile');
    const sessionOption = document.querySelector('#sesion');
    const form = document.querySelector('#form');
    const iniciar = document.querySelector('#iniciar');
    let hiddenInp = document.querySelector('#sesionOpcion');

    options.style.display = 'none';
    const button = document.querySelector('.selOpt');

    button.addEventListener('click', function(e){
      e.preventDefault();
      button.style.display = 'none';
      options.style.display = 'block';
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
</body>

</html>