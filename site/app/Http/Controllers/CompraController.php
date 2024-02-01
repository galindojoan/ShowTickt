<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompraController extends Controller
{
  public function compra(Request $request)
  {
    // $datosArray = json_decode($request->input('datos_array'));
    var_dump($request);
    // return view('confirmarCompra',compact('esdeveniment','dato'));
  }
}
