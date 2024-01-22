@extends('layouts.master')

@section('title', 'Recuperar')

@section('content')
<div class="loginPage">
    @if($errors->has('error'))
        <span class="errorMsg">{{$errors->first('error')}}</span>
    @endif
    <div class="login">
        <h2>Contraseña Olvidada</h2>
        <span id="indicador">Escriba la cuenta a recuperar.</span> <br> <br>
        <form action="{{route('recuperar-form')}}" method="post" id="recuperarForm">
        @csrf
            <div class="loginInput">
                <input type="email" name="email" id="email" placeholder="Email">
            </div>
            <div>
                <a href="{{route('login')}}" class="boton" id="atras">Atrás</a>
                <input type="submit" value="Enviar" class="boton">
            </div>
        </form>
    </div>
</div>
@endsection
