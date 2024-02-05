<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompraController extends Controller
{
  public function compra(Request $request)
  {
    $nomEvent= $request->input('detallesEvents');
    $total=$request->input('inputTotal');
    $entradaArray = json_decode($request->input('arrayEntradas'));
    $sessionArray = json_decode($request->input('inputSession'));
    var_dump($sessionArray);
    // return view('confirmarCompra',compact('nomEvent','entradaArray','sessionArray','total'));
  }
  
}
