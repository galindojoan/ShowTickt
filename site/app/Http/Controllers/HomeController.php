<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Esdeveniment;
use App\Models\Categoria;
use Illuminate\Support\Facades\Config;
use Illuminate\Pagination\LengthAwarePaginator;

class HomeController extends Controller
{
    public function index()
    {
        $pag = Config::get('app.items_per_page', 9);
        $esdeveniments = Esdeveniment::with(['recinte'])->paginate($pag);
        $categories = Categoria::all();

        return view('home', ['esdeveniments' => $esdeveniments, 'categories' => $categories]);
    }

    public function cerca(Request $request)
    {
        $cerca = $request->input('q');
        $categoryId = $request->input('category');

        $query = Esdeveniment::query();

        if ($cerca) {
            $query->whereRaw('LOWER(nom) LIKE ?', ["%" . strtolower($cerca) . "%"])
                ->orWhereHas('recinte', function ($query) use ($cerca) {
                    $query->whereRaw('LOWER(lloc) LIKE ?', ["%" . strtolower($cerca) . "%"]);
                });
        }

        // Verifica si la categoría seleccionada no es "Todas las categorías"
        if ($categoryId !== '') {
            $query->where('categoria_id', $categoryId);
        }

        $esdeveniments = $query->paginate(config('app.items_per_page', 9));

        $categories = Categoria::all();

        return view('home', compact('esdeveniments', 'categories', 'categoryId'));
    }
}
