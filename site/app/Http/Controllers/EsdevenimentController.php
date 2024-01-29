<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use App\Models\Esdeveniment;
use Illuminate\Http\Request;
use Geocoder\Laravel\Facades\Geocoder;


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
      $provincia = str_replace(' ', '+', $esdeveniment->provincia);
      $lloc = str_replace(' ', '+', $esdeveniment->lloc);
      
      $direccion = $provincia . '+' . $lloc;

    $client = new Client();
    try {
        $response = $client->get('https://nominatim.openstreetmap.org/search?q='. $direccion.'&format=json', [
            'verify' => false,
        ]);

        $data = json_decode($response->getBody(), true);

        if (!empty($data)) {
          $lat = $data[0]['lat'] ?? null;
          $long = $data[0]['lon'] ?? null;
        } 
    } catch (\Exception $e) {
        $lat = null;
        $long = null;
    }

    return view('detallesLocal', compact('esdeveniment','lat','long'));
  }
}
