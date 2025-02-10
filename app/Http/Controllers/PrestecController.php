<?php

namespace App\Http\Controllers;

use App\Models\Prestec;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class PrestecController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Log::info('Listado de Prestamos');
    
        $prestecs = Prestec::with('joc','usuari', 'joc.bgg' )->get();
        
        //Log::debug($prestecs);

        $items = $this->getListadoPrestecs();
        $response = ['prestecs' => $items];
        
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
        

        $prestec = Prestec::create ([
            'jocId' => $request['jocId'],
            'uid' => $request['uid'],
            'dataInici' => $request['dataInici'],
            'dataFi' => $request['dataFi'],         
        ]);
        $prestec->save();

        Log::info('Insertando nuevo prestamo');
        

        $items = $this->getListadoPrestecs();
        $response = ['prestecs' => $items];
        
        return response()->json($response);   

  
    }

    /**
     * Display the specified resource.
     */
    public function show(Prestec $prestec)
    {
        //

        $items = $this->getListadoPrestecs();
        $response = ['prestecs' => $items];
        
        return response()->json($response);   
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prestec $prestec)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $prestec = Prestec::find($request['prestecId']);
 
        $prestec->dataInici = $request['dataInici'];
        $prestec->dataFi = $request['dataFi'];

        $prestec->save();
        
        
        $items = $this->getListadoPrestecs();
        $response = ['prestecs' => $items];
        
        return response()->json($response);   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $prestecId)
    {
        //
        $res=Prestec::find($prestecId)->delete();

        $prestecs = $this->getListadoPrestecs();

        $response = ['prestecs' => $prestecs];
                    
        return response()->json($response);
    }

    protected function formatPrestec($item)
    {
           
   
            $joc = array(
                //'jocId' => $item['joc']['jocId'],
                'joc' => $item['joc']['joc'],
                //'ambit' => $item['joc']['ambit'],
                //'tipologia' => $item['joc']['tipologia'],
                //'expansio' => $item['joc']['bgg']['expansio'],
                'imatge' => $item['joc']['bgg']['imatge'],
                //'comentaris' => $item['joc']['comentaris'],
                //'edat' => $item['joc']['bgg']['edat'],
                //'bggId' => $item['joc']['bgg']['bggId'],
                //'dificultat' => $item['joc']['bgg']['dificultat'],
                //'maxJugadors' => $item['joc']['bgg']['maxJugadors'],
                //'minJugadors' => $item['joc']['bgg']['minJugadors'],
              ); 
              $usuari = array(
                //'rol' => $item['usuari']['rol'],  
                'uid' => $item['usuari']['uid'],  
                //'email' => $item['usuari']['email'],  
                //'parella' => $item['usuari']['parella'],  
                //'photoURL' => $item['usuari']['photoURL'],  
                'displayName' => $item['usuari']['displayName'],  
              ); 
    
              $prestec = array (
                'prestecId' => $item['prestecId'],   
                'dataInici' => $item['dataInici'],  
                'dataFi' => $item['dataFi'],    
                'joc' => $joc,
                'usuari' => $usuari,          
              );
                
        return $prestec;
    }

    protected function getListadoPrestecs(){

        $prestecs = Prestec::with('joc','usuari', 'joc.bgg' )->where('dataFi',null)->get();
        $items = [];
        foreach ($prestecs as $p){ 
            $item = $this->formatPrestec($p);
            array_push($items,  $item);
        }
        
        return $items;

    }
}
