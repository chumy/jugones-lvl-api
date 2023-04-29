<?php

namespace App\Http\Controllers;


use App\Models\Joc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class JocController extends Controller
{
    public function show(string $jocId)
    {

        $client = new \Nataniel\BoardGameGeek\Client();
            
    
        $thing = $client->getThing($jocId , true);


        $joctmp = new Joc ([
            'bggId' => $thing->getId(),          
            'minJugadors' => $thing->getMinPlayers(),
            'maxJugadors' =>$thing->getMaxPlayers(),
            'dificultat' => $thing->getWeightAverage(),
            'duracio' => $thing->getPlayingTime(),
            'edat' => $thing->getMinAge(),
            'expansio' => $thing->isBoardgameExpansion(),
            'imatge' => $thing->getThumbnail(),
            'name' => $thing->getName()
        ]);
          
        $response = ['jocs' => $joctmp];
         
        return response()->json($joctmp);
    }
}
