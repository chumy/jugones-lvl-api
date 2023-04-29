<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Coleccio extends Model
{
    use HasUuids;

    protected $table = "Coleccio";// <-- El nombre personalizado
    protected $primaryKey = 'jocId';
    public $incrementing = false;
    protected $keyType='string';

    protected $fillable = [
        'jocId',
        'joc',
        'tipologia',
        'ambit',
        'comentaris',
        'bggId',
    ];

    

    public function bgg()
    {
        return $this->hasOne(Joc::class,'bggId','bggId');
    }

    public function prestecs()
    {
        return $this->hasMany(Prestec::class,'jocId','jocId');
    }

    public function prestec()
    {
        return $this->hasOne(Prestec::class,'jocId','jocId')->whereNull('dataFi');
    }
    

 
}
