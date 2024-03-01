<?php

namespace App\Http\Controllers;

use App\Models\Opinion;
use App\Models\Categoria;
use App\Models\Esdeveniment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;

class OpinionController extends Controller
{
    public function newOpinionPage(Request $request)
    {
        // Obtener el ID del evento desde la solicitud
        $id = $request->input('event-id');
        if (!isset($id)) {
            $pag = Config::get('app.items_per_page', 100);
            $categoryId = ''; // Establece un valor predeterminado
        
            $esdeveniments = Esdeveniment::with(['recinte'])
              // Ordenar por fecha descendente
              ->paginate($pag);
        
            $events = Esdeveniment::getAllEvents($pag);
        
            $categories = Categoria::all();
            $categoriesWithEventCount = (new Categoria())->getCategoriesWithEventCount();
        
            $categoriesWith3 = Categoria::getCategoriesWith3();
            return view('home', compact('esdeveniments', 'categories', 'categoryId', 'categoriesWithEventCount', 'events', 'categoriesWith3'));
        } else {

            // Redirigir a la vista de crear opinión y pasar el $eventoId si es necesario
            return view('crearOpinion', compact('id'));
        }
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
