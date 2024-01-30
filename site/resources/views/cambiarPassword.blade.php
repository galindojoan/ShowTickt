@extends('layouts.master')

@section('title', 'Cambiar contraseña')

@section('content')
<div class="login">
    @if ($errors->has('error'))
        <span class="msg-error">{{$errors->first('error')}}</span>
    @endif
    <div class="login-div">
        <h2>Cambiar Contraseña</h2>
        <form action="{{route('peticionCambiar')}}" method="post" class="login-form">
        @csrf
            <div class="login-input">
                <input type="hidden" name="userId" value="{{$_GET['user']}}">
                <input type="password" name="password" id="password" placeholder="Nueva contraseña" required>
            </div>
            <input type="submit" value="Cambiar" class="boton">
        </form>
    </div>
</div>
@endsection