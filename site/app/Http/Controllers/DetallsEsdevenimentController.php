<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DetallsEsdevenimentController extends Controller
{
    public function show($id)
    {
        // Lógica para mostrar detalles del esdeveniment
        return view('detallsEsdeveniments');
    }
}
