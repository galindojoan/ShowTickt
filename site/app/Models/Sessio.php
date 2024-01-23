<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sessio extends Model
{
    use HasFactory;

    protected $fillable = ['data', 'tancament', 'nominal', 'aforament', 'esdeveniments_id'];

    public function esdeveniment()
    {
        return $this->belongsTo(Esdeveniment::class, 'esdeveniments_id');
    }

    public function entrades()
    {
        return $this->hasMany(Entrada::class, 'sessios_id');
    }
}
