<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Esdeveniment;
use Illuminate\Support\Facades\Config;

class HomeController extends Controller
{
    public function index()
    {
        $pag = Config::get('app.items_per_page', 9);
        $esdeveniments = Esdeveniment::with(['recinte'])->paginate($pag);

        return view('home', ['esdeveniments' => $esdeveniments]);
    }
}
