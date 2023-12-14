<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Esdeveniment;
use Illuminate\Support\Facades\Config;
use Illuminate\Pagination\LengthAwarePaginator;

class HomeController extends Controller
{
    public function index()
    {
        $pag = Config::get('app.items_per_page', 9);
        $esdeveniments = Esdeveniment::with(['recinte'])->paginate($pag);

        return view('home', ['esdeveniments' => $esdeveniments]);
    }

    public function cerca(Request $request)
    {
        $cerca = $request->input('q');

        $esdeveniments = Esdeveniment::whereRaw('LOWER(nom) LIKE ?', ["%" . strtolower($cerca) . "%"])
            ->orWhereHas('recinte', function ($query) use ($cerca) {
                $query->whereRaw('LOWER(lloc) LIKE ?', ["%" . strtolower($cerca) . "%"]);
            })
            ->paginate(config('app.items_per_page', 9)); // Paginación con el mismo número de elementos por página que en la página principal

        return view('home', compact('esdeveniments'));
    }
}
