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
      <h1 class="titulo">ShowTickt</h1>
      <img class="logo" alt="logoShowTickt" src="{{ asset('imagen/logo-definitivo.png') }}">
  </header>
  <div>
    @yield('content') 
  </div>
  <footer>
    <a href="{{ route('home') }}">HOME</a>
  </footer>
</body>

</html>