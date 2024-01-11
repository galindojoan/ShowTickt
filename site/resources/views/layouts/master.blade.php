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
    
    <div id="options">
      <button id="svg"><svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#ffffff" d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z"/></svg></button>
      @if(session('key'))
      <select onfocus='this.size=2;' onblur='this.size=0;' onchange='this.size=1; this.blur();' class="userOptions">
        <option class="optionProfile" value="" selected hidden>{{ session('key') }}</option>
        <option class="optionProfile" value="profile">Perfil de usuario</option>
        <option class="optionProfile" value="closeSession">Cerrar sesión</option>
      </select>
      @else
      <input type="button" class="ahref" value="Iniciar Sesión">
      @endif
    </div>
  </header>
  <div>
    @yield('content') 
  </div>
  <footer>
    <a id="footerHome" href="{{ route('home') }}">HOME</a>
    <form method="@if(session('key'))
     POST 
     @else GET 
     @endif" 
     action="@if(session('key'))
    {{route('homePromotor')}}
    @else{{route('login')}}
    @endif">
    @csrf
      <input class="ahref" type="submit" value="PROMOTORES">
    </form>
  </footer>
</body>

</html>