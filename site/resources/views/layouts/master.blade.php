<!doctype html>
<html lang="ca"> 

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('imagen/logo-definitivo.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
    <title>@yield('title')</title> 
    @if(session('key'))
      <select>
        <option value="" selected>{{ session('key') }}</option>
        <option value="profile">Perfil de usuario</option>
        <option value="closeSession">Cerrar sesión</option>
      </select>
    @endif
</head>

<body class="w3-content">
  <header>
    <img class="logo" alt="logoShowTickt" src="{{ asset('imagen/logo-definitivo.png') }}">
      <h1 class="titulo">ShowTickt</h1>
      
  </header>
  <div>
    @yield('content') 
  </div>
  <footer>
    <a id="footerHome" href="{{ route('home') }}">HOME</a>
    <a id="footerHome" href="@if(session('key'))
      {{route('homePromotor')}}
      @else{{route('login')}}
      @endif">PROMOTORES</a>
  </footer>
</body>

</html>