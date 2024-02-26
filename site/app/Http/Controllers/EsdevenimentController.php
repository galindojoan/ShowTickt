<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use App\Models\Esdeveniment;


class EsdevenimentController extends Controller
{
  public function show($id)
  {
    // $esdeveniment = Esdeveniment::findOrFail($id);
    $esdeveniment = Esdeveniment::getFirstEventLocal($id);

    $fechas = Esdeveniment::getSessiosEvent($id);
    $entradas = Esdeveniment::getEntradesEvent($id);
    $preuTotal = 0;
    $fechaSola=false;
    // var_dump($esdeveniment);
    return view('esdeveniment', compact('esdeveniment', 'fechas', 'entradas', 'preuTotal','fechaSola'));
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
