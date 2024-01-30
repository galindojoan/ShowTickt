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

  public function getCategoriesWithEventCount()
  {
    $categories = Categoria::all();

    $categoriesWithEventCount = $categories->map(function ($category) {
      $category->eventCount = Esdeveniment::join(
        DB::raw('(SELECT esdeveniments_id, MIN(data) as min_data FROM sessios GROUP BY esdeveniments_id) as min_dates'),
        function ($join) use ($category) {
          $join->on('esdeveniments.id', '=', 'min_dates.esdeveniments_id')
            ->where('esdeveniments.categoria_id', $category->id);
        }
      )
        ->leftJoin('sessios', function ($join) {
          $join->on('esdeveniments.id', '=', 'sessios.esdeveniments_id')
            ->on('sessios.data', '=', 'min_dates.min_data');
        })
        ->select('esdeveniments.*', 'min_dates.min_data as min_data')
        ->where('esdeveniments.ocult', false) // Filtrar eventos no ocultos
        ->where('min_dates.min_data', '>', now())

        ->count();

      return $category;
    });

    return $categoriesWithEventCount;
  }

  public function index()
  {
    $pag = Config::get('app.items_per_page', 100);
    $categoryId = ''; // Establece un valor predeterminado

    $esdeveniments = Esdeveniment::with(['recinte'])
      // Ordenar por fecha descendente
      ->paginate($pag);

    $events = Esdeveniment::join(
      DB::raw('(SELECT esdeveniments_id, MIN(data) as min_data 
                          FROM sessios 
                          GROUP BY esdeveniments_id) as min_dates'),
      function ($join) {
        $join->on('esdeveniments.id', '=', 'min_dates.esdeveniments_id');
      }
    )
      ->join('sessios', function ($join) {
        $join->on('sessios.esdeveniments_id', '=', 'min_dates.esdeveniments_id')
          ->on('sessios.data', '=', 'min_dates.min_data');
      })
      ->join('entradas', 'entradas.sessios_id', '=', 'sessios.id')
      ->join('categories', 'categories.id', '=', 'esdeveniments.categoria_id')
      ->select('esdeveniments.*', 'sessios.data as data_sessio', 'entradas.preu as entradas_preu')
      ->where('esdeveniments.ocult', false) // Filtrar eventos no ocultos
      ->orderBy('data_sessio', 'asc')
      ->groupBy('esdeveniments.id', 'sessios.data', 'entradas.preu')
      ->get();

    $categories = Categoria::all();
    $sessio = Sessio::all();
    $categoriesWithEventCount = $this->getCategoriesWithEventCount();
    $categoriesWith3 = DB::table('categories')
      ->join('esdeveniments', 'categories.id', '=', 'esdeveniments.categoria_id')
      ->select('categories.*', DB::raw('COUNT(esdeveniments.id) as event_count'))
      ->groupBy('categories.id')
      ->havingRaw('COUNT(esdeveniments.id) > 1')
      ->get();

    return view('home', compact('esdeveniments', 'categories', 'categoryId', 'categoriesWithEventCount', 'sessio', 'events', 'categoriesWith3'));
  }



  public function quitarAcentos($cadena)
  {
    $acentos = [
      'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
      'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U',
      'ä' => 'a', 'ë' => 'e', 'ï' => 'i', 'ö' => 'o', 'ü' => 'u',
      'Ä' => 'A', 'Ë' => 'E', 'Ï' => 'I', 'Ö' => 'O', 'Ü' => 'U',
    ];

    return strtr($cadena, $acentos);
  }


  public function cerca(Request $request)
  {
    $cerca = $this->quitarAcentos($request->input('q'));
    $categoryId = $request->input('category');

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
      ->where('esdeveniments.ocult', false) // Filtrar eventos no ocultos
      ->where('min_dates.min_data', '>', now()) // Filtrar eventos cuya fecha mínima sea mayor que la fecha local actual
      ->orderBy('min_data', 'asc'); // Ordenar por fecha mínima de sesión ascendente


    // Verifica si se ha seleccionado una categoría
    if ($categoryId !== null) {
      $query->where('categoria_id', $categoryId);

      // Aplica la búsqueda solo si hay una categoría seleccionada
      if ($cerca) {
        $query->where(function ($query) use ($cerca, $categoryId) {
          $query->whereRaw('LOWER(nom) LIKE ?', ["%" . strtolower($cerca) . "%"])
            ->where('categoria_id', $categoryId);
        })
          ->orWhereHas('recinte', function ($query) use ($cerca, $categoryId) {
            $query->whereRaw('LOWER(lloc) LIKE ?', ["%" . strtolower($cerca) . "%"])
              ->where('categoria_id', $categoryId);
          });
      }
    } else {
      // No hay categoría seleccionada, busca en todos los eventos
      if ($cerca) {
        $query->where(function ($query) use ($cerca) {
          $query->whereRaw('LOWER(nom) LIKE ?', ["%" . strtolower($cerca) . "%"])
            ->orWhereHas('recinte', function ($query) use ($cerca) {
              $query->whereRaw('LOWER(lloc) LIKE ?', ["%" . strtolower($cerca) . "%"]);
            });
        });
      }
    }

    $esdeveniments = $query->paginate(config('app.items_per_page', 6))->appends(request()->query());

    $categories = Categoria::all();

    $categoriesWithEventCount = $this->getCategoriesWithEventCount();
    $sessio = Sessio::all();

    $eventsOrdenats = Esdeveniment::join(
      DB::raw('(SELECT esdeveniments_id, MIN(data) as min_data 
                        FROM sessios 
                        GROUP BY esdeveniments_id) as min_dates'),
      function ($join) {
        $join->on('esdeveniments.id', '=', 'min_dates.esdeveniments_id');
      }
    )
      ->join('sessios', function ($join) {
        $join->on('sessios.esdeveniments_id', '=', 'min_dates.esdeveniments_id')
          ->on('sessios.data', '=', 'min_dates.min_data');
      })

      ->join(
        DB::raw('(SELECT sessios_id, MIN(preu) as min_preu 
                      FROM entradas 
                      GROUP BY sessios_id) as min_preus'),
        function ($join) {
          $join->on('sessios.id', '=', 'min_preus.sessios_id');
        }
      )
      ->join('entradas', function ($join) {
        $join->on('entradas.sessios_id', '=', 'min_preus.sessios_id')
          ->on('entradas.preu', '=', 'min_preus.min_preu');
      })
      ->join('categories', 'categories.id', '=', 'esdeveniments.categoria_id')
      ->select('esdeveniments.*', 'sessios.data as data_sessio', 'entradas.preu as entradas_preu')
      ->where('categories.id', '=', $categoryId)
      ->orderBy('data_sessio', 'asc')
      ->groupBy('esdeveniments.id', 'sessios.data', 'entradas.preu')
      ->paginate(config('app.items_per_page', 6)); // Ajusta el valor según tus necesidades

    // $eventsNoData = $query->paginate(config('app.items_per_page', 6))->appends(request()->query());

    return view('resultados', compact('esdeveniments', 'categories', 'categoryId', 'categoriesWithEventCount', 'sessio', 'eventsOrdenats'));
  }
}
