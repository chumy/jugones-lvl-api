<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $table = "Participants";// <-- El nombre personalizado
    public $incrementing = false;

    protected $fillable = [
            'partidaId',
         'soci', 
         'propietario', 
         'explicador', 
         'need_explicacion', 
        ];

    public function participant()
    {
            return $this->hasOne(User::class,'uid','soci');
    }

}
