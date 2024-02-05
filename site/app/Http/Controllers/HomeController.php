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

class HomeController extends Controller
{

  public function index()
  {
    $pag = Config::get('app.items_per_page', 100);
    $categoryId = ''; // Establece un valor predeterminado

    $esdeveniments = Esdeveniment::with(['recinte'])
      // Ordenar por fecha descendente
      ->paginate($pag);

    $events = Esdeveniment::getAllEvents($pag);

    $categories = Categoria::all();
    $categoriesWithEventCount = (new Categoria())->getCategoriesWithEventCount();

    $categoriesWith3 = Categoria::getCategoriesWith3();

    return view('home', compact('esdeveniments', 'categories', 'categoryId', 'categoriesWithEventCount', 'events', 'categoriesWith3'));
  }

  public function cerca(Request $request)
  {
    $cerca = $request->input('q');
    $categoryId = $request->input('category');

    $esdeveniments = Categoria::getFilteredEvents($cerca, $categoryId);

    $categories = Categoria::all();
    $categoriesWithEventCount = (new Categoria())->getCategoriesWithEventCount();
    $sessio = Sessio::all();

    $eventsOrdenats = Esdeveniment::getOrderedEvents($categoryId);

    return view('resultados', compact('esdeveniments', 'categories', 'categoryId', 'categoriesWithEventCount', 'sessio', 'eventsOrdenats'));
  }
}
