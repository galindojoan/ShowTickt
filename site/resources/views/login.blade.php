@extends('layouts.master')

@section('title', 'Login')

@section('content')
<div class="loginPage">
    @if($errors->has('error'))
        <span class="errorMsg">{{$errors->first('error')}}</span>
    @elseif($errors->has('vali'))
        <span class="valiMsg">{{$errors->first('vali')}}</span>
    @endif
    <div class="login">
        <h2>Login</h2>
        <form action="{{route('homePromotor')}}" method="post" id="loginForm">
        @csrf
            <div class="loginInput">
                <input type="text" name="usuario" id="usuario" placeholder="Usuario" required>
                <input type="password" name="password" id="password" placeholder="Contraseña" required>
                <a href="recuperar">Contraseña olvidada?</a>
            </div>
            <input type="submit" value="Acceder" class="boton">
        </form>
    </div>
</div>
@endsection