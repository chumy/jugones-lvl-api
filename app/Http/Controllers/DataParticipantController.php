<?php

namespace App\Http\Controllers;

use App\Models\DataPartida;
use App\Models\DataParticipant;
use App\Models\Partida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;


class DataParticipantController extends Controller
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
        Log::info('Agregando participante');
        $participant = DataParticipant::create([
            'dataId' => $request['data'],        
            'uid' => $request['usuari']['uid'],
            ]);
            $participant->save();
    
            
            $items = DataPartida::where('partidaId', $request['partida']['partidaId'])->with('participants', 'participants.participant' )->get();
            //$items = Partida::where('partidaId', $partidaId)->with('joc','organitzador', 'participants', 'participants.participant' )->get();

            //Log::info(print_r($items,true));
        
            $status = 200;
            
            $response = ['partides' => $items, 'status' => $status];
    
            //$response = ['partides' => $items];
            
            return response()->json($response);   
    }

    /**
     * Display the specified resource.
     */
    public function show(DataParticipant $dataParticipant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataParticipant $dataParticipant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataParticipant $dataParticipant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Log::info("Borrando Fecha de Participante ".$request['data']);
         
        $participant = DataParticipant::
                where([ ['dataId', $request['data']],
                      ['uid', $request['usuari']['uid'] ] ])->delete();
       

        $items = DataPartida::where('partidaId', $request['partida']['partidaId'])->with('participants')->get();

        $response = ['partides' => $items];
        
        return response()->json($response);   
    }
}
