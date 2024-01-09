@extends('layouts.master')

@section('title', 'Login')

@section('content')
<div class="loginPage">
    <div class="login">
        <h2>Login</h2>
        <div class="loginInput">
            <input type="text" name="usuario" id="usuario" placeholder="Usuario">
            <input type="text" name="password" id="password" placeholder="Contraseña">
            <a href="">Contraseña olvidada?</a>
        </div>
        <input type="submit" value="Acceder" class="boton">
    </div>
</div>
@endsection