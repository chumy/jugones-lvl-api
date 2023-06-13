<?php

namespace App\Http\Controllers;

use App\Models\DataPartida;
use App\Models\Partida;
use App\Models\DataParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\PartidaFechaNueva;

class DataPartidaController extends Controller
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

        Log::Info("Creando fecha propuesta");
        $data = DataPartida::create([
            'partidaId' => $request['partida']['partidaId'],        
            'data' => $request['data'],
        ]);

        $data->save();

        /*Log::info("1 -".$data->id());
        Log::info("2 -".$data->dataid);

        //Log::info(print_r($data, true));

        $data = DataPartida::where([
            ['partidaId', $request['partida']['partidaId']],        
            ['data',$request['data']],            
        ])->first();

        //Log::info(print_r($data, true));*/
        
        $participant = DataParticipant::create([
        'dataId' => $data->id(),        
        'uid' => $request['usuari']['uid'],
        ]);
        $participant->save();

        
        $items = DataPartida::where('partidaId', $request['partida']['partidaId'])->with('participants')->get();
        //$partida = Partida::where('partidaId',  $request['partida']['partidaId'])->get();

        
            //$status = 200;
            
            //$response = ['partides' => $partida, 'status' => $status];

        if(count($items) > 0){
            $status = 201;
        }else{
            $status = 204;
        }
        Log::debug($status);
        
        $response = ['partides' => $items, 'status' => $status];

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
            Mail::to($emails)->send(new PartidaFechaNueva($request['partida']['partidaId'], $request['usuari']['uid'], $request['data']));
        }

        return response()->json($response);   

    }

    /**
     * Display the specified resource.
     */
    public function show(string $partidaId)
    {
        //

        Log::info('Obteniendo fechas propuestas');
        $items = DataPartida::where('partidaId', $partidaId)->with('participants')->get();

       
        $status = 200;
       

        Log::debug($status);
        
        $response = ['partides' => $items, 'status' => $status];
    
        
        return response()->json($response);   
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataPartida $dataPartida)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataPartida $dataPartida)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
         //

         Log::info("Borrando fecha".$request['data']);
         
         $participant = DataParticipant::where('dataId', $request['data'] )->delete();
        
         $partida = DataPartida::where('dataId', $request['data'] )->delete();

         $items = DataPartida::where('partidaId', $request['partida']['partidaId'])->with('participants')->get();
 
         
            $status = 210;
        
        
        $response = ['partides' => $items, 'status' => $status];
         
         return response()->json($response);   
    }
}
