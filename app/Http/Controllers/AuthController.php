<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /*


        const {  uid, displayName, email, photoURL } = req.body;
        //Check Email
        const [rows] = await pool.query(
          "SELECT COUNT(*) as emails FROM Usuaris where email = ?",
          [email]
        );
        console.log("checking emails ", rows[0].emails);
        if (rows[0].emails == 0){
          // insert
          const [rows] = await pool.query(
            "INSERT INTO Usuaris (uid, displayName, email, rol, photoURL) VALUES (?, ?, ?, ?, ?)",
            [uid, displayName, email, rol, photoURL]
          );

          usuario.uid = uid;
          usuario.displayName= displayName;
          usuario.email = email;
          usuario.rol = rol;
          usuario.photoURL = photoURL;
          usuario.parella = '';
          
          console.log("insertando ", usuario)

        }else{
          // get Role
          //console.log("usuario existe")
          const [usuaris] = await pool.query("SELECT uid, displayName, email, rol, photoURL, parella FROM Usuaris where email = ?", [email]);
          //console.log(usuaris[0])
          usuario = usuaris[0];
          // chequeamos el uid por si el usuario ha sido introducido manualmente
          if (usuario.uid != uid)
          {
            usuario.uid = uid;
            usuario.photoURL = photoURL;
            const [rows] = await pool.query("UPDATE FROM Usuaris set uid = ?, photoURL = ? where email = ? ", [uid, photoURL, email])
            console.log( "usuario actualizado correctamente")
          }
        
        }

          // Create a token
      const token = jwt.sign({ id: uid }, SECRET, {
        expiresIn:  432000, // 5 days
      });

        res.status(201).json({usuario , token } );
        */

    public function login(Request $request){

        if (!User::where('email', $request['email'])->exists()) {    
            
            $user = User::create ([
                'uid' => $request['uid'],
                'email' => $request['email'],
                'displayName' => $request['displayName'],
                'rol' => 0,
                'photoURL' => $request['photoURL'],
                'parella' => '',
            ]);
            $user->save();

        }

        $user = User::where('email', $request['email'])->first();
        $token = $user->createToken('auth_token')->plainTextToken;

        Log::info($user);

        return response()->json([
            'token' => $token,
            'usuario' => $user,
                ]);
    }
}
