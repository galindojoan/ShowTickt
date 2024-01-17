@extends('layouts.master')

@section('title', 'Recuperar')

@section('content')
<div class="loginPage">
    <div class="login">
        <h2>Contraseña Olvidada</h2>
        @if($errors->has('msg'))
            <span class="errorMsg">El email no esta vinculado con ninguno de nuestros usuarios.</span>
        @endif
        
        <span>Escriba el email de la cuenta a recuperar.</span> <br> <br>
        <form action="{{route('recuperar-form')}}" method="post" id="recuperarForm">
        @csrf
            <div class="loginInput">
                <input type="email" name="email" id="email" placeholder="Email">
            </div>
            <button class="boton" id="atras">Atrás</button>
            <input type="submit" value="Acceder" class="boton">
        </form>
    </div>
</div>
@endsection