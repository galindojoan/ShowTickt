<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Esdeveniment;
use App\Models\Categoria;
use Illuminate\Support\Facades\Config;
use Illuminate\Pagination\LengthAwarePaginator;

class HomeController extends Controller
{

    public function getCategoriesWithEventCount()
    {
        $categories = Categoria::all();

        $categoriesWithEventCount = $categories->map(function ($category) {
            $category->eventCount = Esdeveniment::where('categoria_id', $category->id)->count();
            return $category;
        });

        return $categoriesWithEventCount;
    }

    public function index()
    {
        $pag = Config::get('app.items_per_page', 6);
        $categoryId = ''; // Establece un valor predeterminado

        $esdeveniments = Esdeveniment::with(['recinte'])
            ->orderBy('dia', 'desc') // Ordenar por fecha descendente
            ->paginate($pag);

        $categories = Categoria::all();

        $categoriesWithEventCount = $this->getCategoriesWithEventCount();

        return view('home', compact('esdeveniments', 'categories', 'categoryId', 'categoriesWithEventCount'));
    }

    

    public function quitarAcentos($cadena)
    {
        $acentos = [
            'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
            'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U',
            'ä' => 'a', 'ë' => 'e', 'ï' => 'i', 'ö' => 'o', 'ü' => 'u',
            'Ä' => 'A', 'Ë' => 'E', 'Ï' => 'I', 'Ö' => 'O', 'Ü' => 'U',
        ];

        return strtr($cadena, $acentos);
    }


    public function cerca(Request $request)
    {
        $cerca = $this->quitarAcentos($request->input('q'));
        $categoryId = $request->input('category');

        $query = Esdeveniment::with(['recinte'])
            ->orderBy('dia', 'desc'); // Ordenar por fecha descendente

        // Verifica si se ha seleccionado una categoría
        if ($categoryId !== null) {
            $query->where('categoria_id', $categoryId);

            // Aplica la búsqueda solo si hay una categoría seleccionada
            if ($cerca) {
                $query->where(function ($query) use ($cerca, $categoryId) {
                    $query->whereRaw('LOWER(nom) LIKE ?', ["%" . strtolower($cerca) . "%"])
                        ->where('categoria_id', $categoryId);
                })
                    ->orWhereHas('recinte', function ($query) use ($cerca, $categoryId) {
                        $query->whereRaw('LOWER(lloc) LIKE ?', ["%" . strtolower($cerca) . "%"])
                            ->where('categoria_id', $categoryId);
                    });
            }
        } else {
            // No hay categoría seleccionada, busca en todos los eventos
            if ($cerca) {
                $query->where(function ($query) use ($cerca) {
                    $query->whereRaw('LOWER(nom) LIKE ?', ["%" . strtolower($cerca) . "%"])
                        ->orWhereHas('recinte', function ($query) use ($cerca) {
                            $query->whereRaw('LOWER(lloc) LIKE ?', ["%" . strtolower($cerca) . "%"]);
                        });
                });
            }
        }

        $esdeveniments = $query->paginate(config('app.items_per_page', 6));

        $categories = Categoria::all();

        $categoriesWithEventCount = $this->getCategoriesWithEventCount();

        return view('home', compact('esdeveniments', 'categories', 'categoryId', 'categoriesWithEventCount'));
    }
}
