<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Joc extends Model
{
    use HasFactory;
    protected $table = "Jocs";// <-- El nombre personalizado
    protected $primaryKey = 'bggId';
    public $incrementing = false;

    protected $fillable = [
        'minJugadors',
         'maxJugadors', 
         'dificultat', 
         'duracio', 
         'edat', 
         'expansio', 
         'bggId',
         'imatge', 
         'name'
        ];


}
