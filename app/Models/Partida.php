<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    use HasFactory;

    protected $table = "Partides";
    protected $primaryKey = 'partidaId';
    public $incrementing = false;

    protected $fillable = [
            'partidaId',
         'organitzador', 
         'bggId', 
         'data', 
         'numJugadors', 
         'oberta',
         'comentaris',
        ];

    public function joc()
    {
            return $this->hasOne(Joc::class,'bggId','bggId');
    }

    public function organitzador()
    {
            return $this->hasOne(User::class,'uid','organitzador');
    }

    public function participants()
    {
        return $this->hasMany(Participant::class,'partidaId','partidaId');
    }

   /* public function participants()
    {
        //return $this->hasMany(Participant::class,'partidaId','partidaId');
        return $this->hasManyThrough(
                User::class,
                Participant::class,
                'partidaId',
                'uid',
                'partidaId',
                'soci');
            
                /*Post::class, //User
            User::class, //Participant
            'country_id', // Foreign key on users table... 
            'user_id', // Foreign key on posts table...
            'id', // Local key on countries table...
            'id' // Local key on users table...*
    }*/

}
