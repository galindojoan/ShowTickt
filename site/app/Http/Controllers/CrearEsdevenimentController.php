<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Esdeveniment;
use App\Models\Categoria;
use App\Models\Recinte;
use App\Models\Sessio;
use App\Models\Entrada;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CrearEsdevenimentController extends Controller
{
    public function index()
    {
        $categories = Categoria::all();
        $recintes = Recinte::all();
        $noRecintes = false;

        if ($recintes->isEmpty()) {
            $noRecintes = true;
        }

        return view('crearEsdeveniment', compact('categories', 'recintes', 'noRecintes'));
    }

    public function create()
    {
        $categories = Categoria::all();
        $recintes = Recinte::all();
        $noRecintes = false;

        if ($recintes->isEmpty()) {
            $noRecintes = true;
        }

        return view('crearEsdeveniment', compact('categories', 'recintes', 'noRecintes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titol' => 'required|string|max:255',
            'categoria' => 'required|exists:categories,id',
            'imatge' => 'required|image',
            'descripcio' => 'required|string',
            'data_hora' => 'required|date',
            'aforament_maxim' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $recinteId = null;

        if ($request->has('recinte') && $request->input('recinte') != '') {
            // Si s'ha seleccionat un recinte existent
            $recinteId = $request->input('recinte');
        } else {
            // Si s'ha seleccionat crear una nova adreça
            $request->validate([
                'nova_nom' => 'required|string|max:255',
                'nova_provincia' => 'required|string|max:255',
                'nova_ciutat' => 'required|string|max:255',
                'nova_codi_postal' => 'required|string|max:255',
                'nova_capacitat' => 'required|integer|min:1',
            ]);

            try {
                // Crea un nou recinte amb les dades proporcionades
                $recinte = new Recinte([
                    'nom' => $request->input('nova_nom'),
                    'provincia' => $request->input('nova_provincia'),
                    'lloc' => $request->input('nova_ciutat'),
                    'codi_postal' => $request->input('nova_codi_postal'),
                    'capacitat' => $request->input('nova_capacitat'),
                    'user_id' => $request->input('nova_user_id'),
                ]);

                $recinte->save();

                if ($recinte) {
                    $recinteId = $recinte->id;
                    Log::info('Se ha creado un nuevo recinto con la id: '.$recinteId);
                } else {
                    // Maneig de l'error, com redirigir l'usuari a una pàgina d'error
                    Log::error('Intento de crear un nuevo recinto fallido');
                }
            } catch (Exception $e) {
                //throw $th;
            }
        }

        try{
            // Generar un nombre único basado en el timestamp y el nombre original del archivo
            $nombreUnico = time() . '_' . $request->file('imatge')->getClientOriginalName();

            $esdeveniment = new Esdeveniment([
                'nom' => $request->input('titol'),
                'categoria_id' => $request->input('categoria'),
                'recinte_id' => $recinteId,
                'imatge' => $request->file('imatge')->storeAs('images', $nombreUnico),
                'descripcio' => $request->input('descripcio'),
                'ocult' => $request->has('ocultarEsdeveniment'),
                'user_id' => $request->input('user_id'),
            ]);

            $esdeveniment->save();

            if ($esdeveniment) {
                $esdevenimentId = $esdeveniment->id;
            }

            // Crear la sessió
            $sessio = new Sessio([
                'data' => $request->input('data_hora'),
                'aforament' => $request->input('aforament_maxim'),
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

            Log::info('Evento nuevo creado con la id: '.$esdevenimentId);
        
        }catch(Exception $e){
            Log::error('Fallo al intentar crer un nuevo evento. Mensaje de error: '.$e->getMessage());
        }

        return redirect()->route('homePromotor')->with('success', 'Evento creado exitosamente');
    }
}
