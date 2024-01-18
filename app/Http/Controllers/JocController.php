<?php

namespace App\Http\Controllers;


use App\Models\Joc;
use App\Models\Prestec;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class JocController extends Controller
{
    public function show(string $jocId)
    {

        $client = new \Nataniel\BoardGameGeek\Client();
            
    
        $thing = $client->getThing($jocId , true, true);

        //Log::info(json_encode($thing));
        //Log::info(print_r($thing->getVideos(), true));

        //Log::info(print_r($thing, true));


        $joctmp = new Joc ([
            'bggId' => $thing->getId(),          
            'minJugadors' => $thing->getMinPlayers(),
            'maxJugadors' =>$thing->getMaxPlayers(),
            'dificultat' => $thing->getWeightAverage(),
            'duracio' => $thing->getPlayingTime(),
            'edat' => $thing->getMinAge(),
            'expansio' => $thing->isBoardgameExpansion(),
            'imatge' => $thing->getThumbnail(),
            'name' => $thing->getName(),
            'videos' => $thing->getVideos(),
        ]);
          
        $response = ['jocs' => $joctmp];
         
        return response()->json($joctmp);
    }

    public function getVideos(string $jocId)
    {

        $client = new \Nataniel\BoardGameGeek\Client();
            
    
        $thing = $client->getThing($jocId , false, true);

        //Log::info(json_encode($thing));
        //Log::info(print_r($thing->getVideos(), true));

        //Log::info(print_r($thing, true));


        $joctmp =  $thing->getVideos();
          
        $response = ['videos' => $joctmp, 'message' => 200];
         
        return response()->json($response);
    }

    public function getPrestec(string $jocId)
    {

        //$prestec = Prestec::where('jocId',$jocId)->where('dataFi', null)->get();
        $prestec = Prestec::where('jocId',$jocId)->get();

        //Log::info(print_r($jocId));
        //Log::info(print_r($thing->getVideos(), true));

        //Log::info(print_r($prestec));

        
        return response()->json($prestec);
    }
}
