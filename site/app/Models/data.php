<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class data extends Model
{
    use HasFactory;
    protected $fillable = ['dia', 'hores'];
    public function esdeveniment()
    {
        return $this->belongsTo(Esdeveniment::class);
    }
}
