<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Esdeveniment;
use App\Models\Categoria;
use App\Models\Recinte;
use Illuminate\Support\Facades\Auth;

class CrearEsdevenimentController extends Controller
{
    public function index()
    {
        $categories = Categoria::all();
        $recintes = Recinte::all();

        return view('crearEsdeveniment', compact('categories', 'recintes'));
    }

    public function create()
    {
        $categories = Categoria::all();
        $recintes = Recinte::all();

        return view('crearEsdeveniment', compact('categories', 'recintes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titol' => 'required|string|max:255',
            'categoria' => 'required|exists:categories,id',
            'recinte' => 'required|exists:recintes,id',
            'imatge' => 'required|image',
            'descripcio' => 'required|string',
            'data_hora' => 'required|date',
            'aforament_maxim' => 'required|integer|min:1',
        ]);

        $user = Auth::user();

        $esdeveniment = new Esdeveniment([
            'nom' => $request->input('titol'),
            'categoria_id' => $request->input('categoria'),
            'recinte_id' => $request->input('recinte'),
            'imatge' => $request->file('imatge')->store('images'),
            'descripcio' => $request->input('descripcio'),
            'dia' => $request->input('data_hora'),
            'preu' => 0, // Precio predeterminado
            'aforament' => $request->input('aforament_maxim'),
            'user_id' => $request->input('user_id'),
        ]);

        $esdeveniment->save();

        return redirect()->route('homePromotor')->with('success', 'Evento creado exitosamente');

    }
}
