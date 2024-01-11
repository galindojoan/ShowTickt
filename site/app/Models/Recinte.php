<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recinte extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'provincia', 'lloc', 'codi_postal', 'capacitat', 'user_id'];
    
    protected $table = 'recintes';

    public function esdeveniments()
    {
        return $this->hasMany(Esdeveniment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}