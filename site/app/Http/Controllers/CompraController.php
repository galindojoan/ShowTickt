<?php

namespace App\Http\Controllers;

use App\Models\Esdeveniment;
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
  public function creacioPdf(Request $request){
    $event = Esdeveniment::getEventById($request->input('id'));
    $entrades = $request->input('arrayEntradas');
    $pdf = app('dompdf.wrapper');
    $pdf->loadView('entradas', compact('event','entrades'));
    return $pdf->download('entradas.pdf');
  }
  
}
