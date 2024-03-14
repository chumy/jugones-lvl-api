<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use DateTime;
use Mockery as m;
use Spatie\GoogleCalendar\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Providers\Reserva;

class ReservaController extends Controller
{
    //

    public function index()
    {
        
        $event = new Event;
        $events = Event::get(); //Retrieve all future events
        
        $reserves = $this->setReservas($events);
        

        //Log::info(print_r($reserves));

        if(count($reserves)){
            $status = 200;
        }else{
            $status = 204;
        }
            
        $response = ['reserves' => $reserves, 'status' => $status];
                
        return response()->json($response);
        
    }

    public function setEvent(){

        $event = new Event;

        $event->name = 'John Doe';
        $event->location = 'Sala 1';
        $event->startDateTime = \Carbon\Carbon::now();
        $event->endDateTime = \Carbon\Carbon::now()->addHour();
        $event->description = 'Descripcion del evento';

        $event->save();

        $events = Event::get();
        $reserves = $this->setReservas($events);
        
        if(count($reserves)){
            $status = 200;
        }else{
            $status = 204;
        }
            
        $response = ['reserves' => $reserves, 'status' => $status];
                
        return response()->json($response);

    }
    
    public function destroy(String $reservaId){

        //$event = new Event;

        $reserva = Event::find($reservaId);
        $reserva->delete();
        
        $events = Event::get();
        $reserves = $this->setReservas($events);
        
        if(count($reserves)){
            $status = 200;
        }else{
            $status = 204;
        }
            
        $response = ['reserves' => $reserves, 'status' => $status];
                
        return response()->json($response);

    }

    public function store(Request $request){

        $event = new Event;


     

        if ($request['sesion'] == 'Tarda'){
            $start = Carbon::createFromFormat("Y-m-d H", $request['fecha']." 16");
            $end = Carbon::createFromFormat("Y-m-d H", $request['fecha']." 20");
        }else{
            $start = Carbon::createFromFormat("Y-m-d H", $request['fecha']." 10");
            $end = Carbon::createFromFormat("Y-m-d H", $request['fecha']." 13");
        }
        
        //Log::info($start);

        $event->name = $request['titulo'];
        $event->location = $request['sala'];
        $event->startDateTime = $start;
        $event->endDateTime = $end;
        $event->description = $request['descripcion'];


        $event->save();

    }
/*
    public function connect()

    {

    $client = GoogleCalendar::getClient();

    $authUrl = $client->createAuthUrl();

    return redirect($authUrl);

    }*/

    public function setReservas($eventos)
    {
        $lista=[];
        foreach ($eventos as $item){ 
            $reserva = new Reserva($item);
            array_push($lista,$reserva);
        }
        return $lista;
    }



   

}
