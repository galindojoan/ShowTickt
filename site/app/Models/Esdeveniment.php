<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Esdeveniment extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'dia', 'imatge', 'preu', 'recinte_id', 'categoria_id'];

    public function recinte()
    {
        return $this->belongsTo(Recinte::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}