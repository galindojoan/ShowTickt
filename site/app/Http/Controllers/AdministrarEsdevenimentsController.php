<?php

namespace App\Http\Controllers;

use App\Models\Esdeveniment;
use Illuminate\Http\Request;

class AdministrarEsdevenimentsController extends Controller
{
    public function index(Request $request)
    {
        // Obtiene el usuario a partir de la sesión
        $userId = $request->session()->get('user_id');

        // Llama a la función del modelo para obtener los eventos
        $esdeveniments = Esdeveniment::getAdminEvents($userId);

        // Pasa los eventos a la vista
        return view('administrarEsdeveniments', ['esdeveniments' => $esdeveniments]);
    }
}
