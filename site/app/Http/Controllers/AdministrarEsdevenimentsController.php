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
        //$esdeveniments = Esdeveniment::with('sesions')->where('user_id', $userId)->paginate(6);

        // Obtén los eventos asociados al usuario con sus sesiones (usando with)
        $query = Esdeveniment::with(['recinte'])
            ->join(
                DB::raw('(SELECT esdeveniments_id, MIN(data) as min_data FROM sessios GROUP BY esdeveniments_id) as min_dates'),
                function ($join) {
                    $join->on('esdeveniments.id', '=', 'min_dates.esdeveniments_id');
                }
            )
            ->leftJoin('sessios', function ($join) {
                $join->on('esdeveniments.id', '=', 'sessios.esdeveniments_id')
                    ->on('sessios.data', '=', 'min_dates.min_data');
            })
            ->select('esdeveniments.*', 'min_dates.min_data as min_data')
            ->where('min_dates.min_data', '>', now()) // Filtrar eventos cuya fecha mínima sea mayor que la fecha local actual
            ->orderBy('min_data', 'asc') // Ordenar por fecha mínima de sesión ascendente
            ->paginate(6); // Puedes usar ->paginate($pag) si deseas paginación

        // Pasa los eventos a la vista
        return view('administrarEsdeveniments', ['esdeveniments' => $query]);
    }
}
