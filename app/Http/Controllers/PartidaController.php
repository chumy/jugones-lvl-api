<?php

namespace App\Http\Controllers;

use App\Models\Partida;
use App\Models\Participant;
use App\Models\Joc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

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

        $response = ['partides' => $partidas];
        
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

        if (!Joc::where('bggId',  $request['joc']['bggId'],)->exists()) {    
            
            $joc = Joc::create ([
                'bggId' => $request['joc']['bggId'],        
                'minJugadors' => $request['joc']['minJugadors'],
                'maxJugadors' =>$request['joc']['maxJugadors'],
                'dificultat' => $request['joc']['dificultat'],
                'duracio' => $request['joc']['duracio'],
                'edat' => $request['joc']['edat'],
                'expansio' => $request['joc']['expansio'],
                'imatge' => $request['joc']['imatge'],
                'name' => $request['joc']['joc'],
            ]);
            $joc->save();

        }

             
        $partida = Partida::create([
            'partidaId' => $request['partidaId'],
            'organitzador' => $request['organitzador']['uid'],
            'bggId' => $request['joc']['bggId'],
            'data' => $request['data'],  
            'numJugadors' => $request['numJugadors'],
            'oberta' => $request['oberta'],
            'comentaris' => $request['comentaris'],

        ]);

        $partida->save();

        
        $participant = Participant::create ([
            'partidaId' => $request['partidaId'],        
            'soci' => $request['organitzador']['uid'],
            'explicador' =>$request['organitzador']['explicador'],
            'propietario' => $request['organitzador']['propietari'],
            'need_explicacion' => $request['organitzador']['need_explicacio'],
        ]);
        $participant->save();
    
        $partidas = $this->getListadoPartidas();
        
        $response = ['partides' => $partidas];
        
        return response()->json($response);   
    }

    /**
     * Display the specified resource.
     */
    public function show(string $partidaId)
    {
        //
        Log::info("buscando partida ".$partidaId);
        $partida = Partida::where('partidaId', $partidaId)->with('joc','organitzador', 'participants' )->get();
        
        $response = ['partides' => $partida];
        
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

        $partida = Partida::find($request['partidaId']);
 
        $partida->bggId = $request['joc']['bggId'];
        $partida->organitzador = $request['organitzador']['uid'];
        $partida->data = $request['data'];
        $partida->oberta = $request['oberta'];
        $partida->comentaris = $request['comentaris'];

        $partida->save();
        
        
        $partidas = $this->getListadoPartidas();
        
        $response = ['partides' => $partidas];
        
        return response()->json($response);   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $partidaId)
    {
        //
        $res=Participant::where('partidaId',$partidaId)->delete();
        $res=Partida::find($partidaId)->delete();

        $partidas = $this->getListadoPartidas();
        
        $response = ['partides' => $partidas];
        
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