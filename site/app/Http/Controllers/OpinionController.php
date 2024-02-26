<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Opinion;

class OpinionController extends Controller
{
    public function newOpinionPage(Request $request){
        // Obtener el ID del evento desde la solicitud
        $id = $request->input('event-id');

        // Redirigir a la vista de crear opinión y pasar el $eventoId si es necesario
        return view('crearOpinion', compact('id'));
    }

    public function store(Request $request)
    {
        $esdevenimentId = $request->input('event-id');
        // Mapear emojis a valores específicos
        $emojiMapping = [
            '😠' => 1,
            '😞' => 2,
            '😐' => 3,
            '😊' => 4,
            '😃' => 5,
        ];

        // Obtener el valor de emocio según el emoji seleccionado
        $emocio = $emojiMapping[$request->input('valoracion')];

        $opinio = new Opinion([
            'nom' => $request->input('nombre'),
            'emocio' => $emocio,
            'puntuacio' => $request->input('puntuacion'),
            'titol' => $request->input('titulo'),
            'comentari' => $request->input('comentario'),
            'esdeveniment_id' => $esdevenimentId,
        ]);

        $opinio->save();

        return redirect()->route('mostrar-esdeveniment', [$esdevenimentId])->with('success', 'Opinion creada correctamente');
    }

}
