<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPartida extends Model
{
    use HasFactory;
    protected $table = "DatesPartides";
    protected $primaryKey = 'dataId';

    protected $fillable = [
        'dataId',
         'partidaId',
         'data', 
        ];

    public function partida()
    {
        return $this->hasOne(Partida::class,'partidaId','partidaId');
    }

    public function participants()
    {
        //return $this->hasMany(Participant::class,'partidaId','partidaId');
        return $this->hasManyThrough(
                User::class,
                DataParticipant::class,
                'dataId',
                'uid',
                'dataId',
                'uid');
            
                /*Post::class, //User
            User::class, //DataParticipant
            'country_id', // Foreign key on DParticiapnt table... 
            'user_id', // Foreign key on User table...
            'id', // Local key on DPArtida table...
            'id' // Local key on DParticiapnt table...*/
    }

    public function id()
    {
        return $this->dataId;
    }
    
    
}
