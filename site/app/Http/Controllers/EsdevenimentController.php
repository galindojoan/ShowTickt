<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\Esdeveniment;
use App\Models\Opinion;
use Illuminate\Http\Request;
use Geocoder\Laravel\Facades\Geocoder;


class EsdevenimentController extends Controller
{
  public function show($id)
  {
    // $esdeveniment = Esdeveniment::findOrFail($id);
    $esdeveniment = Esdeveniment::join('sessios', 'sessios.esdeveniments_id', '=', 'esdeveniments.id')
      ->join('entradas', 'entradas.sessios_id', '=', 'sessios.id')
      ->select('esdeveniments.*')
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
    $fechaSola = false;

    // Obtener opiniones asociadas al evento
    $opiniones = Opinion::where('esdeveniment_id', $id)->get();

    foreach ($opiniones as $opinion) {
      $opinion->emocio = $this->getEmoji($opinion->emocio);
      $opinion->estrellas = $this->convertirPuntuacionAEstrellas($opinion->puntuacio);
    }

    return view('esdeveniment', compact('esdeveniment', 'fechas', 'entradas', 'preuTotal', 'fechaSola', 'opiniones'));
  }

  private function getEmoji($emocio)
  {
    $emojis = [
      '1' => '😠',
      '2' => '😞',
      '3' => '😐',
      '4' => '😊',
      '5' => '😃',
    ];

    return $emojis[$emocio] ?? '';
  }

  private function convertirPuntuacionAEstrellas($puntuacion)
  {
    $estrellas = '';
    for ($i = 1; $i <= 5; $i++) {
      $clase = ($i <= $puntuacion) ? 'star selected' : 'star';
      $estrellas .= "<span class=\"$clase\" data-rating=\"$i\">&#9733;</span>";
    }
    return $estrellas;
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
    $response = $client->get('https://nominatim.openstreetmap.org/search?q=' . $direccion . '&format=json', [
      'verify' => false,
    ]);

    $data = json_decode($response->getBody(), true);

    if (!empty($data)) {
      $lat = $data[0]['lat'] ?? null;
      $long = $data[0]['lon'] ?? null;
    }

    return view('detallesLocal', compact('esdeveniment', 'lat', 'long'));
  }
}
