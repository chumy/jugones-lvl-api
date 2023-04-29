<?php

namespace App\Http\Controllers;

use App\Models\Partida;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;


class ParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

        $participant = Participant::create ([
            'partidaId' => $request['partida']['partidaId'],        
            'soci' => $request['participant']['uid'],
            'explicador' =>$request['participant']['explicador'],
            'propietario' => $request['participant']['propietari'],
            'need_explicacion' => $request['participant']['need_explicacio'],
        ]);
        $participant->save();
    
        $partida = Partida::where('partidaId', $request['partida']['partidaId'] )->with('joc','organitzador', 'participants' )->get();

        $response = ['partides' => $partida];
        
        return response()->json($response);  
            
    }

    /**
     * Display the specified resource.
     */
    public function show(Participant $participant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Participant $participant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Participant $participant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        Log::info("Borrando participantes ". $request['participant'] ." de la partida ".$request['partida']['partidaId'] );

        $participant = Participant::where([
                ['partidaId',$request['partida']['partidaId']],
                ['soci', $request['participant'] ]
                ])->delete();
            
        $partida = Partida::where('partidaId', $request['partida']['partidaId'] )->with('joc','organitzador', 'participants' )->get();

        $response = ['partides' => $partida];
        
        return response()->json($response);  
       
    }
}
