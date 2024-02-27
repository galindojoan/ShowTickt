<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sessio extends Model
{
    use HasFactory;

    protected $fillable = ['data', 'tancament', 'aforament', 'esdeveniments_id','estado'];

    public function esdeveniment()
    {
        return $this->belongsTo(Esdeveniment::class, 'esdeveniments_id');
    }

    public function entrades()
    {
        return $this->hasMany(Entrada::class, 'sessios_id');
    }

    public function getUserSessions($userId)
    {
        return $this->with(['esdeveniment.recinte', 'esdeveniment.user'])
            ->whereHas('esdeveniment', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->where('data', '>', now()) // Sesiones futuras
            ->orderBy('data', 'asc')
            ->paginate(6);
    }
    public static function getSessionbyID($SessionId)
    {
        return DB::table('sessios')
            ->where('sessios.id', '=', $SessionId)
            ->first();
    }
}
