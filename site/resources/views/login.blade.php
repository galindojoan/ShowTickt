@extends('layouts.master')

@section('title', 'Login')

@section('content')
<div class="loginPage">
    <div class="login">
        <h2>Login</h2>
        @if($errors->has('msg'))
            <span class="errorMsg">Usuario o contraseña incorrecta</span>
        @endif
        <form action="{{route('homePromotor')}}" method="post" id="loginForm">
        @csrf
            <div class="loginInput">
                <input type="text" name="usuario" id="usuario" placeholder="Usuario">
                <input type="password" name="password" id="password" placeholder="Contraseña">
                <a href="">Contraseña olvidada?</a>
            </div>
            <input type="submit" value="Acceder" class="boton">
        </form>
    </div>
</div>
@endsection