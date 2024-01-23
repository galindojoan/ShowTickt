<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Esdeveniment;
use App\Models\Sessio;
use App\Models\Entrada;

class EditarEsdevenimentController extends Controller
{
    public function editar($id)
    {
        $esdeveniment = Esdeveniment::findOrFail($id);
        
        $fechas = Esdeveniment::join('sessios','sessios.esdeveniments_id','=','esdeveniments.id')
          ->select('esdeveniments.*', 'sessios.data as data_sessio')
          ->where('esdeveniments.id', '=', $id)
          ->get();
        
        return view('editarEsdeveniment', compact('esdeveniment','fechas'));
    }

    public function newSessionPage(Request $request){
        $id = $request->input('event-id');
        return view('añadirSesion', compact('id'));
    }
    public function newSesion(Request $request){
        $esdevenimentId = $request->input('event-id');

        // Crear la sessió
        $sessio = new Sessio([
            'data' => $request->input('data_hora'),
            'tancament' => $request->input('dataHoraPersonalitzada'),
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
        
        return redirect()->route('homePromotor')->with('success', 'Evento creado exitosamente');
    }
}
