<?php

namespace App\Http\Controllers;

use App\Models\DataPartida;
use App\Models\DataParticipant;
use App\Models\Partida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\PartidaParticipanteFecha;


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
    
            
            //$items = DataPartida::where('partidaId', $request['partida']['partidaId'])->with('participants', 'participants.participant' )->get();
            $items = DataPartida::where('partidaId', $request['partida']['partidaId'])->with('participants')->get();
            //$items = Partida::where('partidaId', $partidaId)->with('joc','organitzador', 'participants', 'participants.participant' )->get();

            //Log::info(print_r($items,true));
        
            $status = 200;

            //Enviar email a los usuarios
            $partida = Partida::where('partidaId', $request['partida']['partidaId'])->get()[0];
            //Log::info(print_r($partida[0],true));
            //Enviar email a los usuarios
            if ($partida->participants){
                $emails = [];
                foreach ($partida->participants as $p){
                    $usuari = $p->participant()->first();
                    array_push($emails, $usuari['email']);
                }
                //Log::info(print_r($emails,true));
                Mail::to($emails)->send(new PartidaParticipanteFecha($request['partida']['partidaId'], $request['usuari']['uid'], $request['data']));
            }

            
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
