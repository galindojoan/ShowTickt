<?php

namespace App\Http\Controllers;

use App\Models\data;
use App\Models\Sessio;
use App\Models\Categoria;
use App\Models\Esdeveniment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Database\Seeders\EsdevenimentsTableSeeder;
use Illuminate\Pagination\LengthAwarePaginator;

class AdministrarEsdevenimentsController extends Controller
{
    public function index(Request $request)
    {
        // Obtiene el usuario a partir de la sesión
        $userId = $request->session()->get('user_id');

        // Obtén los eventos asociados al usuario con sus sesiones (usando with)
        $esdeveniments = Esdeveniment::with('sesions')->where('user_id', $userId)->paginate(6);

        // Pasa los eventos a la vista
        return view('administrarEsdeveniments', ['esdeveniments' => $esdeveniments]);
    }
}
