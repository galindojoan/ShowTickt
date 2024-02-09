<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Esdeveniment extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'descripcio', 'ocult', 'recinte_id', 'categoria_id', 'user_id'];

    public function recinte()
    {
        return $this->belongsTo(Recinte::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sesions()
    {
        return $this->hasMany(Sessio::class, 'esdeveniments_id');
    }

    public function opinions()
    {
        return $this->hasMany(Opinion::class, 'esdeveniments_id');
    }

    public function imatge()
    {
        return $this->hasMany(EsdevenimentImatge::class, 'esdeveniments_id');
    }

    public static function getAdminEvents($userId)
    {
        return self::with(['recinte'])
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
            ->where('min_dates.min_data', '>', now())
            ->where('user_id', $userId) // Filter events by user_id
            ->orderBy('min_data', 'asc')
            ->paginate(6);
    }

    public static function getAllEvents($pag)
    {
        return self::with(['recinte'])
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
            ->where('min_dates.min_data', '>', now())
            ->orderBy('min_data', 'asc')
            ->paginate($pag);
    }

    public static function getOrderedEvents($categoryId)
    {
        return self::join(
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
            ->paginate(config('app.items_per_page', 6));
    }
    public static function getEventById($id){
        return DB::table('esdeveniment')->where('id','=',$id)->first();
    }
}
