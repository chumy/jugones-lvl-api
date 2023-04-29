<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataParticipant extends Model
{
    use HasFactory;
    protected $table = "DatesParticipants";

    protected $fillable = [
        'dataId',
         'uid'
        ];
    
}
