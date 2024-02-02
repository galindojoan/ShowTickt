<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opinion extends Model
{
    use HasFactory;

    protected $fillable = ['esdeveniment_id', 'nom', 'emocio', 'puntuacio', 'titol', 'comentari'];

    public function esdeveniment()
    {
        return $this->belongsTo(Esdeveniment::class);
    }
}