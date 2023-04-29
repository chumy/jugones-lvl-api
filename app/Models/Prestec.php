<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Prestec extends Model
{
    use HasFactory, HasUuids;

    protected $table = "Prestecs";// <-- El nombre personalizado
    protected $primaryKey = 'prestecId';
    public $incrementing = false;

    protected $fillable = [
        'jocId',
         'uid', 
         'dataInici', 
         'dataFi', 
         'comentaris', 
         'prestecId',
        ];

    public function joc()
    {
            return $this->hasOne(Coleccio::class,'jocId','jocId');
    }

    public function usuari()
    {
        return $this->hasOne(User::class,'uid','uid');
    }

    public function bgg()
    {
        return $this->hasOneThrough(
        Joc::class,       // Model destino
        Coleccio::class,      // Modelo intermedio
        'jocId',                 // FK de Coleccio
        'bggId',                 // FK de Joc
        'jocId',        // key Prestec
        'bggId'          // key Coleccio
       
        /*Post::class, //Joc
    User::class, //Coleccio
    'country_id', // Foreign key on users table... 
    'user_id', // Foreign key on posts table...
    'id', // Local key on countries table...
    'id' // Local key on users table...*/
        
    );
    }
}
