@extends('layouts.master')

@section('title', 'targeta')
@section('content')

    <div class="login">
      <div class="login-div">
          <h2>Forma de pago</h2>
          <form action="{{ route('finCompra') }}" method="post" class="login-form" id="ComprarEntrada">
            @csrf
            <div class="login-input">
                <label>Tarjeta de credito</label>
                <input type="text" name="tarjetaCredito">
                <label>fecha de caducidad</label>
                <input type="text" name="fechaCaducidad" maxlength="5">
                <label>CVV</label>
                <input type="number" name="cvv" maxlength="3">
                <input type="hidden" name="Ds_SignatureVersion" value="HMAC_SHA256_V1">
                <input type="hidden" name="Ds_MerchantParameters" value="{{ $params }}">
                <input type="hidden" name="Ds_Signature" value="{{ $signature }}">
            </div>
            <button type="submit" id="buttonCompra" class="btn btn-orange">Acceder</button>
        </form>
      </div>
  </div>
@endsection
