@extends('layouts.master')

@section('title', 'Cambiar contraseña')

@section('content')
<div class="loginPage">
    <div class="login">
        <h2>Cambiar Contraseña</h2>
        @if ($errors->has('error'))
            <span class="errorMsg">{{$errors->first('error')}}</span>
        @endif
        <form action="{{route('peticionCambiar')}}" method="post" id="loginForm">
        @csrf
            <div class="loginInput">
                <input type="hidden" name="userId" value="{{$_GET['user']}}">
                <input type="password" name="password" id="password" placeholder="Nueva contraseña" required>
            </div>
            <input type="submit" value="Cambiar" class="boton">
        </form>
    </div>
</div>
@endsection