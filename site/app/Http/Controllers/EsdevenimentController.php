<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Esdeveniment;

class EsdevenimentController extends Controller
{
    public function show($id)
    {
        // $esdeveniment = Esdeveniment::findOrFail($id);
        $esdeveniment = Esdeveniment::join('sessios','sessios.esdeveniments_id','=','esdeveniments.id')
          ->join('entradas','entradas.sessios_id','=','sessios.id')
          ->select('esdeveniments.*', 'sessios.data as data_sessio','entradas.preu as entradas_preu')
          ->where('esdeveniments.id', '=', $id)
          ->first();
          $fechas = Esdeveniment::join('sessios','sessios.esdeveniments_id','=','esdeveniments.id')
          ->select('sessios.*')
          ->where('esdeveniments.id', '=', $id)
          ->get();
          $entradas = Esdeveniment::join('sessios','sessios.esdeveniments_id','=','esdeveniments.id')
          ->join('entradas','entradas.sessios_id','=','sessios.id')
          ->select('entradas.*')
          ->where('esdeveniments.id', '=', $id)
          ->get();
          $preuTotal = 0;
        return view('esdeveniment', compact('esdeveniment','fechas','entradas','preuTotal'));
    }
    public function compra()
    {
        return view('confirmarCompra');
    }
    public function local($id)
    {
      $esdeveniment = Esdeveniment::join('recintes','recintes.id','=','esdeveniments.recinte_id')
          ->select('recintes.*')
          ->where('esdeveniments.id', '=', $id)
          ->first();
        return view('detallesLocal',compact('esdeveniment'));
    }
}
