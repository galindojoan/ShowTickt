<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompraEntrada extends Model
{
    use HasFactory;

    protected $fillable = ['compra_id','nomComprador','dni','numeroIdentificador','tel','entrada_id'];

    public static function isNumeroIdentificadorUnique($num){
        $count = DB::table('compra_entradas')->where('numeroIdentificador', $num)->count();
        return $count === 0;
    }
    public function entrada()
    {
        return $this->belongsTo(Entrada::class, 'entrada_id');
    }


    public function compras()
    {
        return $this->belongsTo(Compra::class, 'compra_id');
    }
    public static function getEntrades($id){
        return self::with('entrada') 
            ->where('compra_id', $id)
            ->get();
    }
}
