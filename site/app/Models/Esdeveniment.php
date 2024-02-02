<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Esdeveniment extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'descripcio', 'imatge', 'ocult', 'recinte_id', 'categoria_id', 'user_id'];

    public function recinte()
    {
        return $this->belongsTo(Recinte::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sesions()
    {
        return $this->hasMany(Sessio::class, 'esdeveniments_id');
    }

    public function opinions()
    {
        return $this->hasMany(Opinion::class, 'esdeveniments_id');
    }
}
