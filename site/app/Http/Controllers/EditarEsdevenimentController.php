<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Sessio;
use App\Models\Entrada;
use App\Models\Esdeveniment;
use App\Models\Opinion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Input\Input;

class EditarEsdevenimentController extends Controller
{
  public function editar($id)
  {
    $esdeveniment = Esdeveniment::findOrFail($id);

    $fechas = Esdeveniment::join('sessios', 'sessios.esdeveniments_id', '=', 'esdeveniments.id')
      ->select('esdeveniments.*', 'sessios.*')
      ->where('esdeveniments.id', '=', $id)
      ->get();


    // Obtener opiniones asociadas al evento
    $opiniones = Opinion::where('esdeveniment_id', $id)->get();

    foreach ($opiniones as $opinion) {
      $opinion->emocio = $this->getEmoji($opinion->emocio);
      $opinion->estrellas = $this->convertirPuntuacionAEstrellas($opinion->puntuacio);
    }

    return view('editarEsdeveniment', compact('esdeveniment', 'fechas', 'opiniones'));
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

  public function newSessionPage(Request $request)
  {
    $id = $request->input('event-id');
    return view('añadirSesion', compact('id'));
  }
  public function newSesion(Request $request)
  {
    try {
      $esdevenimentId = $request->input('event-id');

      // Crear la sessió
      $sessio = new Sessio([
        'data' => $request->input('data_hora'),
        'tancament' => $request->input('dataHoraPersonalitzada'),
        'aforament' => $request->input('aforament_maxim'),
        'esdeveniments_id' => $esdevenimentId,
      ]);
      $sessio->save();

      if ($sessio) {
        $sessioId = $sessio->id;
      }

      // Obtener datos de las entradas
      $noms = $request->input('entrades-nom');
      $preus = $request->input('entrades-preu');
      $quantitats = $request->input('entrades-quantitat');
      $nominal = $request->input('entradaNominalCheck');

      // Procesar los datos según sea necesario
      for ($i = 0; $i < count($noms); $i++) {
        $entrada = new Entrada([
          'nom' => $noms[$i],
          'preu' => $preus[$i],
          'quantitat' => $quantitats[$i],
          'nominal' => $nominal[$i],
          'sessios_id' => $sessioId,
        ]);

        $entrada->save();
      }
      Log::info('Creada nueva sesion para el evento ' . $esdevenimentId);
    } catch (Exception $e) {
      Log::error('Error al intentar crear la nueva sesion para el evento ' . $esdevenimentId . '. Mensaje de error: ' . $e->getMessage());
    }

    return redirect()->route('editar-esdeveniment', [$esdevenimentId]);
  }

  public function updateSesionPage(Request $request)
  {
    $id = $request->input('eventoId');
    $sessioId = $request->input('fechaId');

    $sessiones = Sessio::where("sessios.id", "=", $sessioId)
      ->first();

    $entradas = Entrada::where("entradas.sessios_id", "=", $sessioId)
      ->get();

    return view('editarSesion', compact('sessioId', 'id', 'sessiones', 'entradas'));
  }

  public function updateSesion(Request $request)
  {
    try {
      $esdevenimentId = $request->input('event-id');
      $sessioId = $request->input('fecha-id');

      Sessio::where('sessios.id', '=', $sessioId)
        ->update([
          'data' => $request->input('data_hora'),
          'tancament' => $request->input('dataHoraPersonalitzada'),
          'aforament' => $request->input('aforament_maxim'),
        ]);

      $entradas = Entrada::where("entradas.sessios_id", "=", $sessioId)->get();
      // Obtener datos de las entradas
      $noms = $request->input('entrades-nom');
      $preus = $request->input('entrades-preu');
      $quantitats = $request->input('entrades-quantitat');
      $nominal = $request->input('entradaNominalCheck');

      // Procesar los datos según sea necesario
      if (count($noms) == count($entradas)) {
        for ($i = 0; $i < count($noms); $i++) {
          Entrada::where('entradas.id', '=', $entradas[$i]->id)
            ->update([
              'nom' => $noms[$i],
              'preu' => $preus[$i],
              'quantitat' => $quantitats[$i],
              'nominal' => $nominal[$i],
              'sessios_id' => $sessioId,
            ]);
        }
      } else if (count($noms) > count($entradas)) {
        for ($i = 0; $i < count($entradas); $i++) {
          Entrada::where('entradas.id', '=', $entradas[$i]->id)
            ->update([
              'nom' => $noms[$i],
              'preu' => $preus[$i],
              'quantitat' => $quantitats[$i],
              'nominal' => $nominal[$i],
              'sessios_id' => $sessioId,
            ]);
        }
        for ($i = count($entradas); $i < count($noms); $i++) {
          $entrada = new Entrada([
            'nom' => $noms[$i],
            'preu' => $preus[$i],
            'quantitat' => $quantitats[$i],
            'nominal' => $nominal[$i],
            'sessios_id' => $sessioId,
          ]);

          $entrada->save();
        }
      } else if (count($noms) < count($entradas)) {
        for ($i = 0; $i < count($noms); $i++) {
          Entrada::where('entradas.id', '=', $entradas[$i]->id)
            ->update([
              'nom' => $noms[$i],
              'preu' => $preus[$i],
              'quantitat' => $quantitats[$i],
              'nominal' => $nominal[$i],
              'sessios_id' => $sessioId,
            ]);
        }
        for ($i = count($noms); $i < count($entradas); $i++) {
          Entrada::where('entradas.id', '=', $entradas[$i]->id)
            ->delete();
        }
      }
      Log::info('Guardada sesion: ' . $sessioId . ' del evento ' . $esdevenimentId);
    } catch (Exception $e) {
      Log::error('Error al intentar guardar la sesion: ' . $sessioId . ' para el evento ' . $esdevenimentId . '. Mensaje de error: ' . $e->getMessage());
    }

    return redirect()->route('editar-esdeveniment', [$esdevenimentId]);
  }
  public function cerrarSesion(Request $request)
  {
    $esdeveniment = Esdeveniment::findOrFail($request->input("eventoId"));
    Sessio::where('sessios.id', '=', $request->input("fechaId"))
      ->update([
        'estado' => false,
      ]);
    $fechas = Esdeveniment::join('sessios', 'sessios.esdeveniments_id', '=', 'esdeveniments.id')
      ->select('esdeveniments.*', 'sessios.*')
      ->where('esdeveniments.id', '=', $request->input("fechaId"))
      ->get();
    // Obtener opiniones asociadas al evento
    $opiniones = Opinion::where('esdeveniment_id', $request->input("eventoId"))->get();

    foreach ($opiniones as $opinion) {
      $opinion->emocio = $this->getEmoji($opinion->emocio);
      $opinion->estrellas = $this->convertirPuntuacionAEstrellas($opinion->puntuacio);
    }
    $estado = false;
    return view('editarEsdeveniment', compact('esdeveniment', 'fechas', 'opiniones', 'estado'));
  }
  public function abrirSesion(Request $request)
  {
    $esdeveniment = Esdeveniment::findOrFail($request->input("eventoId"));
    Sessio::where('sessios.id', '=', $request->input("fechaId"))
      ->update([
        'estado' => true,
      ]);
    $fechas = Esdeveniment::join('sessios', 'sessios.esdeveniments_id', '=', 'esdeveniments.id')
      ->select('esdeveniments.*', 'sessios.*')
      ->where('esdeveniments.id', '=', $request->input("fechaId"))
      ->get();
    // Obtener opiniones asociadas al evento
    $opiniones = Opinion::where('esdeveniment_id', $request->input("eventoId"))->get();

    foreach ($opiniones as $opinion) {
      $opinion->emocio = $this->getEmoji($opinion->emocio);
      $opinion->estrellas = $this->convertirPuntuacionAEstrellas($opinion->puntuacio);
    }
    $estado = true;
    return view('editarEsdeveniment', compact('esdeveniment', 'fechas', 'opiniones', 'estado'));
  }
}
