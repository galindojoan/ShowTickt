<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sessio extends Model
{
    use HasFactory;

    protected $fillable = ['data', 'esdeveniments_id'];

    public function esdeveniment()
    {
        return $this->belongsTo(Esdeveniment::class);
    }
}
