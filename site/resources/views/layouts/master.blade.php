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
    <select onfocus='this.size=2;' onblur='this.size=0;' onchange='this.size=1; this.blur();' class="userOptions">
      @if(session('key'))
      <option class="optionProfile" value="" selected hidden>{{ session('key') }}</option>
      <option class="optionProfile" value="profile">Perfil de usuario</option>
      <option class="optionProfile" value="closeSession">Cerrar sesión</option>
      @else
      <option value="session">Iniciar Session</option>
      @endif
    </select>
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
</body>

</html>