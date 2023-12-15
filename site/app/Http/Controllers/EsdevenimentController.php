<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Esdeveniment;

class EsdevenimentController extends Controller
{
    public function show($id)
    {
        $esdeveniment = Esdeveniment::findOrFail($id);
        return view('esdeveniment', compact('esdeveniment'));
    }
}
