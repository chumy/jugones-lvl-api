<?php

namespace App\Http\Controllers;

use App\Models\Partida;
use App\Models\Participant;
use App\Models\Joc;
use App\Models\User;
use Carbon\Carbon;
use App\Models\DataPartida;
use App\Models\DataParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\PartidaUpdated;
use App\Mail\PartidaNueva;
use App\Mail\PartidaNuevaInvitado;



class PartidaController extends Controller
{
    //
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //   
       
        $partidas = $this->getListadoPartidas();

        if(count($partidas) > 0){
        
            $status = 200;
        }else{
            $status = 204;
        }

        $response = ['partides' => $partidas, 'status' => $status];
        
        return response()->json($response);   
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        Log::info("Creando partida ");

        if (!Joc::where('bggId',  $request['partida']['joc']['bggId'],)->exists()) {    
            
            $joc = Joc::create ([
                'bggId' => $request['partida']['joc']['bggId'],        
                'minJugadors' => $request['partida']['joc']['minJugadors'],
                'maxJugadors' =>$request['partida']['joc']['maxJugadors'],
                'dificultat' => $request['partida']['joc']['dificultat'],
                'duracio' => $request['partida']['joc']['duracio'],
                'edat' => $request['partida']['joc']['edat'],
                'expansio' => $request['partida']['joc']['expansio'],
                'imatge' => $request['partida']['joc']['imatge'],
                'name' => $request['partida']['joc']['name'],
            ]);
            $joc->save();

        }
        
             
        $partida = Partida::create([
            'partidaId' => $request['partida']['partidaId'],
            'organitzador' => $request['partida']['organitzador']['uid'],
            'bggId' => $request['partida']['joc']['bggId'],
            'data' => ($request['partida']['data']) ? Carbon::parse($request['data']): null,  
            'numJugadors' => $request['partida']['numJugadors'],
            'oberta' => $request['partida']['oberta'],
            'comentaris' => $request['partida']['comentaris'],

        ]);
       

        $partida->save();

        
        $participant = Participant::create ([
            'partidaId' => $request['partida']['partidaId'],        
            'soci' => $request['partida']['organitzador']['uid'],
            'explicador' =>$request['partida']['organitzador']['explicador'],
            'propietario' => $request['partida']['organitzador']['propietari'],
            'need_explicacion' => $request['partida']['organitzador']['need_explicacio'],
        ]);
        $participant->save();

        Log::info("Listado de invitados ".sizeof($request['convidats']));

        $partidas = $this->getListadoPartidas();

        if(count($partidas) > 0){
            $status = 201;
        }else{
            $status = 204;
        }

        //Enviar email a los usuarios
         $usuaris = (sizeof($request['convidats']) == 0) ? User::where('avisos',1)->get() : $request['convidats'] ;
         $emails = [];
         foreach ($usuaris as $usuari){
             //$usuari = $p;
             if ($usuari['avisos'] == 1){
                //array_push($emails, $usuari['email']);
                if (sizeof($request['convidats']) == 0)
                    Mail::to($usuari['email'])->send(new PartidaNueva($request['partida']['partidaId']));
                else
                    Mail::to($usuari['email'])->send(new PartidaNuevaInvitado($request['partida']['partidaId']));
             }
         }

        
        ///Log::info($emails);  
       
        

        $response = ['partides' => $partidas, 'status' => $status];
                
        return response()->json($response);   
    }

    /**
     * Display the specified resource.
     */
    public function show(string $partidaId)
    {
        //
     

        Log::info("buscando partida ".$partidaId);
        //DB::enableQueryLog();
        $partida = Partida::where('partidaId', $partidaId)->with('joc','organitzador', 'participants', 'participants.participant' )->get();
        //error_log("Hola ".$partida);
        //$partidaT = Partida::where('partidaId', $partidaId)->with('joc','organitzador', 'participants', 'participants.participant')->getBindings();
        $status = 200;
        //print_r($partidaT );
        //Log::info("SQL ");
        //error_log(DB::getQueryLog());
       
        $response = ['partides' => $partida, 'status' => $status];
        
        return response()->json($response);   
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Partida $partida)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
        Log::info("Actualizando Partida ".$request['partidaId']);
        $partida = Partida::find($request['partidaId']);
 
        $partida->bggId = $request['joc']['bggId'];
        $partida->organitzador = $request['organitzador']['uid'];
        $partida->data = $request['data'];
        $partida->oberta = $request['oberta'];
        $partida->numJugadors = $request['numJugadors'];
        $partida->comentaris = $request['comentaris'];

        $partida->save();
                
        //$partidas = $this->getListadoPartidas();
        
        $status = 211;
                
        $partida = Partida::where('partidaId', $request['partidaId'])->with('joc','organitzador', 'participants', 'participants.participant' )->first();

        $response = ['partides' => $partida, 'status' => $status];

        //Enviar email a los usuarios
        $emails = [];
        foreach ($partida->participants as $p){
            $usuari = $p->participant()->first();
            array_push($emails, $usuari['email']);
        }
        //Log::info(print_r($emails,true));
        Mail::to($emails)->send(new PartidaUpdated($request['partidaId']));
        
        return response()->json($response);   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $partidaId)
    {
        //

       // Log::info("PArtida ". $partidaId);

       /* $data=DataPartida::where('partidaId',$partidaId)->get();
       
        $res=DataParticipant::where('dataId',$data['dataId'])->delete();
        
        $res=Participant::where('partidaId',$partidaId)->delete();
        
        $res=DataPartida::find($data['dataId'])->delete();
        */

        $res=Partida::find($partidaId)->delete();
        Log::info("Borrado de partida ->".$partidaId);

        

        

        $partidas = $this->getListadoPartidas();
        
        if(count($partidas) > 0){
            $status = 210;
        }else{
            $status = 204;
        }
        
        $response = ['partides' => $partidas, 'status' => $status];
        
        return response()->json($response);   
    }

    private function getListadoPartidas(){


    
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
        ->get();
    }
}
