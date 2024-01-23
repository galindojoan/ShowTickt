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

class LlistatSessionsController extends Controller
{
    public function index(Request $request)
    {
        // Obtiene el usuario a partir de la sesión
        $userId = $request->session()->get('user_id');

        // Obtén las sesiones asociadas al usuario y ordenadas por fecha
        $sesiones = Sessio::with(['esdeveniment.recinte', 'esdeveniment.user'])
            ->whereHas('esdeveniment', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->where('data', '>', now()) // Sesiones futuras
            ->orderBy('data', 'asc')
            ->paginate(6);

        // Pasa las sesiones a la vista
        return view('llistatSessions', ['sesiones' => $sesiones]);
    }
}
