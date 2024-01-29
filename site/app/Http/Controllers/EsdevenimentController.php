<?php

namespace App\Http\Controllers;
use Geocoder\Laravel\Facades\Geocoder;
use Illuminate\Http\Request;
use App\Models\Esdeveniment;


class EsdevenimentController extends Controller
{
  public function show($id)
  {
    // $esdeveniment = Esdeveniment::findOrFail($id);
    $esdeveniment = Esdeveniment::join('sessios', 'sessios.esdeveniments_id', '=', 'esdeveniments.id')
      ->join('entradas', 'entradas.sessios_id', '=', 'sessios.id')
      ->select('esdeveniments.*', 'sessios.data as data_sessio', 'entradas.preu as entradas_preu')
      ->where('esdeveniments.id', '=', $id)
      ->first();
    $fechas = Esdeveniment::join('sessios', 'sessios.esdeveniments_id', '=', 'esdeveniments.id')
      ->select('sessios.*')
      ->where('esdeveniments.id', '=', $id)
      ->get();
    $entradas = Esdeveniment::join('sessios', 'sessios.esdeveniments_id', '=', 'esdeveniments.id')
      ->join('entradas', 'entradas.sessios_id', '=', 'sessios.id')
      ->select('entradas.*')
      ->where('esdeveniments.id', '=', $id)
      ->get();
    $preuTotal = 0;
    return view('esdeveniment', compact('esdeveniment', 'fechas', 'entradas', 'preuTotal'));
  }
  public function compra()
  {
    return view('confirmarCompra');
  }
  public function local($id)
  {
    $esdeveniment = Esdeveniment::join('recintes', 'recintes.id', '=', 'esdeveniments.recinte_id')
      ->select('recintes.*')
      ->where('esdeveniments.id', '=', $id)
      ->first();
    $direccion = $esdeveniment->provincia . ', ' . $esdeveniment->lloc;

    $lloc = Geocoder::getCoordinatesForAddress('Carrer de Calaf, 08227, Terrassa, Barcelona, Spain')->get();
      // $cordenadas = $lloc->getCoordinates();
      // $lat = $cordenadas->getLatitude();
      // $long = $cordenadas->getLongitude();
    
    $direccion = $esdeveniment->provincia . ', ' . $esdeveniment->lloc;

    return view('detallesLocal', compact('esdeveniment','lloc'));
  }
}
