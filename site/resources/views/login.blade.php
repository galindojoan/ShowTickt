@extends('layouts.master')

@section('title', 'Login')

@section('content')
<div class="login">
    @if($errors->has('error'))
        <span class="msg-error">{{$errors->first('error')}}</span>
    @elseif($errors->has('vali'))
        <span class="msg-valido">{{$errors->first('vali')}}</span>
    @endif
    <div class="login-div">
        <h2>Login</h2>
        <form action="{{route('iniciarSesion')}}" method="post" id="loginForm" class="login-form">
        @csrf
            <div class="login-input">
                <input type="text" name="usuario" id="usuario" placeholder="Usuario" required>
                <input type="password" name="password" id="password" placeholder="Contraseña" required>
                <a href="recuperar">Contraseña olvidada?</a>
            </div>
            <input type="submit" value="Acceder" class="boton">
        </form>
    </div>
</div>
@endsection