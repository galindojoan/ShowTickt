<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EsdevenimentImatge extends Model
{
    use HasFactory;

    protected $fillable = ['esdeveniments_id', 'imatge'];

    public function esdeveniment()
    {
        return $this->belongsTo(Esdeveniment::class, 'esdeveniments_id');
    }
}
