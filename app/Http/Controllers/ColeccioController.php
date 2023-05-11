<?php

namespace App\Http\Controllers;

use App\Models\Coleccio;
use App\Models\Joc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ColeccioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        

            $prestado = DB::table('Prestecs')
                    ->selectRaw("sum(IF(dataFi is null, 1, 0)) as prestado, jocId as pId")
                    ->groupBy('jocId');



            $jocs = Coleccio::with('bgg')
                    ->leftJoinSub($prestado, 'prestec', function ($join)
                    {
                        $join->on('Coleccio.jocId', '=', 'prestec.pId');
                    })

            ->get();

            $jocs = $this->getColeccio();

            if(count($jocs) > 0){
                $status = 200;
            }else{
                $status = 204;
            }
            
            $response = ['jocs' => $jocs, 'status' => $status];
                    
            return response()->json($response);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Log::info($request);
        
        $coleccio = Coleccio::create ([
            'jocId' => $request['jocId'],
            'joc' => $request['joc'],
            'tipologia' => $request['tipologia'],
            'ambit' => $request['ambit'],
            'comentaris' => $request['comentaris'],
            'bggId' => $request['bggId'],          
        ]);
        $coleccio->save();

        Log::info('Insertando nuevo juego');

        if ($request['bggId'] > 0)
        {
            if (!Joc::where('bggId', $request['bggId'])->exists()) {    
            
                $joc = Joc::create ([
                    'bggId' => $request['bggId'],          
                    'minJugadors' => $request['minJugadors'],
                    'maxJugadors' => $request['maxJugadors'],
                    'dificultat' => $request['dificultat'],
                    'duracio' => $request['duracio'],
                    'edat' => $request['edat'],
                    'expansio' => $request['expansio'],
                    'imatge' => $request['imatge'],
                    'name' => $request['joc'],
                ]);
                $joc->save();
            }
        }



        $jocs = $this->getColeccio();

        if(count($jocs) > 0){
            $status = 201;
        }else{
            $status = 204;
        }
        
        $response = ['jocs' => $jocs, 'status' => $status];

        return response()->json($response);

       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $jocId)
    {
        
        

        $prestado = DB::table('Prestecs')
                    ->selectRaw("sum(IF(dataFi is null, 1, 0)) as prestado, jocId as pId")
                    ->groupBy('jocId');



            $jocs = Coleccio::with('bgg')
                    ->leftJoinSub($prestado, 'prestec', function ($join)
                    {
                        $join->on('Coleccio.jocId', '=', 'prestec.pId');
                    })
                    ->where('jocId',$jocId)

            ->get();

       
            $status = 200;
       

        $response = ['joc' => $jocs, 'status' => $status];
         
        return response()->json($response);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coleccio $coleccio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
        Log::info( $request['jocId']);

        $coleccio = Coleccio::where('jocId',$request['jocId'])
            ->update ([
            'joc' => $request['joc'],
            'tipologia' => $request['tipologia'],
            'ambit' => $request['ambit'],
            'comentaris' => $request['comentaris'],
            'bggId' => $request['bggId'],          
        ]);

        Log::info('Actualizando juego ->'.$request['joc']);

        
        $jocs = $this->getColeccio();

       
        $status = 211;
      
          
        
        $response = ['jocs' => $jocs, 'status' => $status];

        return response()->json($response);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $jocId)
    {
        //
        $res=Coleccio::find($jocId)->delete();

        $jocs = $this->getColeccio();

        if(count($jocs) > 0){
            $status = 210;
        }else{
            $status = 204;
        }
        
        $response = ['jocs' => $jocs, 'status' => $status];
                
        return response()->json($response);

    }

    public function searchBggByName (string $query)
    {
        Log::info("entradon en busqueda BGG");

        $client = new \Nataniel\BoardGameGeek\Client();
        
 


        $url = "https://api.geekdo.com/xmlapi2/search?query=".$query."&type=boardgame";
    
        Log::info("Buscando en BGG".$url);

        $responseXML = Http::get($url);
        $xmlObject = simplexml_load_string($responseXML);
        $parseEncode = json_encode($xmlObject);
        $responseBgg = json_decode($parseEncode,true);


    
        if ($responseBgg["@attributes"]["total"] > 0 ) {

            $ids=[];
            $items = [];

            if ($responseBgg["@attributes"]["total"] == 1 ) {
                $responseBgg["item"]["@attributes"]["id"];
                array_push($ids,$responseBgg["item"]["@attributes"]["id"]);
            }
            else {

            
                foreach ($responseBgg["item"] as $item){ 
    
                array_push($ids,$item["@attributes"]["id"] );
                }
                $listIds = implode(",",array_slice($ids,0,100));

            }

            $things = $client->getThings(array_slice($ids,0,100) , true);
     
            foreach ($things as $thing){ 

      
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
              
                array_push($items, $joctmp);
            }
            $status = 200;
        } 
        else{
            $items = null;
            $status = 204;
        }

        $response = ['jocs' => $items, 'status' => $status];

       return response()->json($items);

    }

    private function getColeccio(){

        $query = 'SELECT C.jocId, C.joc, C.ambit, C.tipologia, JB.expansio, JB.imatge '
        ." , IF(PD.jocId is null, 1, 0) disponible "
        ." from Coleccio C "
        ." left outer join (select jocId from Prestecs P where P.dataFi is null) PD on PD.jocId = C.jocId "
        ." left outer join Jocs JB on JB.bggId = C.bggId "
        ." order by C.joc asc";        
        $jocs = DB::select( $query );

        return $coleccio = Coleccio::select('jocId','joc','ambit','tipologia','bggId')
        ->with(
            ['bgg' => function ($query) {
            $query->select('bggId','expansio', 'imatge');
            },
            'prestec' => function ($query) {
                $query->selectRaw("jocId, sum(IF(dataFi is null, 1, 0)) as prestado")
                    ->groupBy('jocId');
            }],
            )
        ->orderBy('joc','asc')->get();


/*
        return $partidas = Partida::
        with('joc','organitzador', 'participants' )
        ->where(function ($query) {
                    $query->where('oberta', '=', '1')
                        ->orWhere( function($q) {
                            $q->whereNull('data')
                              ->where('oberta',0);
                            })
                        ->orWhere( 
                                    function($q) {
                                        $q->whereRaw('data >= ADDDATE(now(), INTERVAL -2 DAY)')
                                          ->where('oberta',0);
                                    }
                        );
                    })
        ->get();*/
    }
}
