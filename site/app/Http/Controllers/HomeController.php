<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Esdeveniment;

class HomeController extends Controller
{
    public function index()
    {
        $esdeveniments = Esdeveniment::with(['recinte'])->get();

        return view('home', ['esdeveniments' => $esdeveniments]);
    }
}
