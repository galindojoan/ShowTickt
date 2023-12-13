<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recinte extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'lloc'];
    
    protected $table = 'recintes';

    public function esdeveniments()
    {
        return $this->hasMany(Esdeveniment::class);
    }
}