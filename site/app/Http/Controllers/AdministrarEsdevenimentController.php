<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdministrarEsdevenimentController extends Controller
{
    public function show($id)
    {
        // Lógica para administrar el esdeveniment
        return view('administrarEsdeveniment');
    }
}
