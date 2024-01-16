<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'preu', 'quantitat', 'sessios_id'];

    public function sessio()
    {
        return $this->belongsTo(Sessio::class);
    }
}
