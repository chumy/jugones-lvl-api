<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    //
       /**
     * Display a listing of the resource.
     */
    public function index()
    {
    
        $usuaris = User::all();
        
        Log::info($usuaris);

        //$items = $this->getListadoPrestecs();
        
        
        if(count($usuaris) > 0){
            $status = 200;
        }else{
            $status = 204;
        }
        $response = ['usuaris' => $usuaris, 'status' => $status];
        
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
        

        $usuari = Usuari::create ([
            'displayName' => $request['displayName'],
            'uid' => $request['uid'],
            'email' => $request['email'],
            'rol' => $request['rol'],         
        ]);
        $usuari->save();

        Log::info('Insertando nuevo usuario');


        $usuaris = User::all();

        if(count($usuaris) > 0){
            $status = 201;
        }else{
            $status = 204;
        }
        $response = ['usuaris' => $usuaris, 'status' => $status];
        
        return response()->json($response);   

  
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uid)
    {
        //

        $usuari = User::find($uid);
        
        return response()->json($usuari);   
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
        Log::info($request);
        $usuari = User::find($request['uid']);
        $usuari->displayName = $request['displayName'];
        $usuari->email = $request['email'];
        $usuari->rol = $request['rol'];
        $usuari->avisos = $request['avisos'];
        $usuari->parella = $request['parella'];
        $usuari->save();
        
        
        $status = 211;
        
        $response = ['usuaris' => $usuari, 'status' => $status];

        return response()->json($usuari);   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uid)
    {
        //
        $res=User::find($uid)->delete();

        $usuaris = User::all();

        if(count($usuaris) > 0){
            $status = 210;
        }else{
            $status = 204;
        }
        $response = ['usuaris' => $usuaris, 'status' => $usuaris];
                    
        return response()->json($response);
    }

 
}
