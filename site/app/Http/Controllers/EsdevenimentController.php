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
          ->select('esdeveniments.*', 'sessios.data as data_sessio')
          ->where('esdeveniments.id', '=', $id)
          ->get();
          $entradas = Esdeveniment::join('sessios','sessios.esdeveniments_id','=','esdeveniments.id')
          ->join('entradas','entradas.sessios_id','=','sessios.id')
          ->select('esdeveniments.*', 'sessios.data as data_sessio','entradas.*')
          ->where('esdeveniments.id', '=', $id)
          ->get();
          $preuTotal = 0;
        return view('esdeveniment', compact('esdeveniment','fechas','entradas','preuTotal'));
    }
    public function compra()
    {
        return view('confirmarCompra');
    }
}
