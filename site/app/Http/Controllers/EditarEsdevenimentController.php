<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Esdeveniment;

class EditarEsdevenimentController extends Controller
{
    public function editar($id)
    {
        $esdeveniment = Esdeveniment::findOrFail($id);
        
        return view('editarEsdeveniment', compact('esdeveniment'));
    }
}
