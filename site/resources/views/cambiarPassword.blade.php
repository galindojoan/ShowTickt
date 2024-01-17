@extends('layouts.master')

@section('title', 'Cambiar pwd')

@section('content')
<div class="loginPage">
    <div class="login">
        <h2>Cambiar Contraseña</h2>
        <form action="{{route('login')}}" method="post" id="loginForm">
        @csrf
            <div class="loginInput">
                <input type="password" name="password" id="password" placeholder="Contraseña" required>
                <input type="password" name="password" id="password" placeholder="Repita Contraseña" required>
            </div>
            <input type="submit" value="Cambiar" class="boton">
        </form>
    </div>
</div>
@endsection