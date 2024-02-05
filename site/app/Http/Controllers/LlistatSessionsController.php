<?php

namespace App\Http\Controllers;

use App\Models\Sessio;
use Illuminate\Http\Request;

class LlistatSessionsController extends Controller
{
    public function index(Request $request)
    {
        // Obtiene el usuario a partir de la sesión
        $userId = $request->session()->get('user_id');

        // Obtén las sesiones asociadas al usuario y ordenadas por fecha
        $sesiones = (new Sessio())->getUserSessions($userId);

        // Pasa las sesiones a la vista
        return view('llistatSessions', ['sesiones' => $sesiones]);
    }
}
