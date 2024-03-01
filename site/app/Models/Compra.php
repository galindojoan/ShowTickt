<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;
    
    protected $fillable = ['sessios_id','quantitat','mailComprador'];

    public function sessio()
    {
        return $this->belongsTo(Sessio::class, 'sessios_id');
    }

    public function compraEntrada()
    {
        return $this->hasMany(CompraEntrada::class, 'compra_id');
    }
}
