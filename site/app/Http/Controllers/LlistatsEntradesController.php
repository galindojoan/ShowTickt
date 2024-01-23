<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LlistatsEntradesController extends Controller
{
    public function show($id)
    {
        // Lógica para mostrar los llistats d'entrades
        return view('llistatsEntrades');
    }
}
