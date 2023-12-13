<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = ['tipus'];

    protected $table = 'categories';

    public function esdeveniments()
    {
        return $this->hasMany(Esdeveniment::class);
    }
};