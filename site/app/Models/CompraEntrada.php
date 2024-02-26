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
}
