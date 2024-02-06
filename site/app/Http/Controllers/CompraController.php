<?php

namespace App\Http\Controllers;

use App\Models\Sessio;
use Illuminate\Http\Request;

class CompraController extends Controller
{
  public function compra(Request $request)
  {
    $nomEvent= $request->input('detallesEvents');
    $total=$request->input('inputTotal');
    $entradaArray = json_decode($request->input('arrayEntradas'));
    $sessionArray = Sessio::getSessionbyID($entradaArray[0]->contadorSession);
    return view('confirmarCompra',compact('nomEvent','entradaArray','sessionArray','total'));
  }
  
}
