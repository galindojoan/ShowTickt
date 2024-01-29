<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Sessio;
use App\Models\Entrada;
use App\Models\Esdeveniment;
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

        return view('editarEsdeveniment', compact('esdeveniment', 'fechas'));
    }

    public function newSessionPage(Request $request)
    {
        $id = $request->input('event-id');
        return view('añadirSesion', compact('id'));
    }
    public function newSesion(Request $request)
    {
        try{
            $esdevenimentId = $request->input('event-id');

            // Crear la sessió
            $sessio = new Sessio([
                'data' => $request->input('data_hora'),
                'tancament' => $request->input('dataHoraPersonalitzada'),
                'aforament' => $request->input('aforament_maxim'),
                'nominal' => $request->has('entradaNominal'),
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

            // Procesar los datos según sea necesario
            for ($i = 0; $i < count($noms); $i++) {
                $entrada = new Entrada([
                    'nom' => $noms[$i],
                    'preu' => $preus[$i],
                    'quantitat' => $quantitats[$i],
                    'sessios_id' => $sessioId,
                ]);

                $entrada->save();
            }
            Log::info('Creada nueva sesion para el evento '.$esdevenimentId);
        }catch(Exception $e){
            Log::error('Error al intentar crear la nueva sesion para el evento '. $esdevenimentId.'. Mensaje de error: '.$e->getMessage());
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
        try{
            $esdevenimentId = $request->input('event-id');
            $sessioId = $request->input('fecha-id');

            Sessio::where('sessios.id', '=', $sessioId)
                ->update([
                    'data' => $request->input('data_hora'),
                    'tancament' => $request->input('dataHoraPersonalitzada'),
                    'aforament' => $request->input('aforament_maxim'),
                    'nominal' => $request->has('entradaNominal'),
                ]);

            $entradas = Entrada::where("entradas.sessios_id", "=", $sessioId)->get();
            // Obtener datos de las entradas
            $noms = $request->input('entrades-nom');
            $preus = $request->input('entrades-preu');
            $quantitats = $request->input('entrades-quantitat');

            // Procesar los datos según sea necesario
            if (count($noms) == count($entradas)) {
                for ($i = 0; $i < count($noms); $i++) {
                    Entrada::where('entradas.id', '=', $entradas[$i]->id)
                        ->update([
                            'nom' => $noms[$i],
                            'preu' => $preus[$i],
                            'quantitat' => $quantitats[$i],
                            'sessios_id' => $sessioId,
                        ]);
                }
            }else if(count($noms) > count($entradas)){
                for ($i=0; $i < count($entradas); $i++) { 
                    Entrada::where('entradas.id', '=', $entradas[$i]->id)
                        ->update([
                            'nom' => $noms[$i],
                            'preu' => $preus[$i],
                            'quantitat' => $quantitats[$i],
                            'sessios_id' => $sessioId,
                        ]);
                }
                for ($i=count($entradas); $i < count($noms); $i++) { 
                    $entrada = new Entrada([
                        'nom' => $noms[$i],
                        'preu' => $preus[$i],
                        'quantitat' => $quantitats[$i],
                        'sessios_id' => $sessioId,
                    ]);
        
                    $entrada->save();
                }
            }else if(count($noms) < count($entradas)){
                for ($i=0; $i < count($noms); $i++) { 
                    Entrada::where('entradas.id', '=', $entradas[$i]->id)
                        ->update([
                            'nom' => $noms[$i],
                            'preu' => $preus[$i],
                            'quantitat' => $quantitats[$i],
                            'sessios_id' => $sessioId,
                        ]);
                }
                for ($i=count($noms); $i < count($entradas); $i++) { 
                    Entrada::where('entradas.id', '=', $entradas[$i]->id)
                        ->delete();
                }
            }
            Log::info('Guardada sesion: '.$sessioId.' del evento '.$esdevenimentId);
        }catch(Exception $e){
            Log::error('Error al intentar guardar la sesion: '.$sessioId.' para el evento '. $esdevenimentId.'. Mensaje de error: '.$e->getMessage());
        }

        return redirect()->route('editar-esdeveniment', [$esdevenimentId]);
    }
}
