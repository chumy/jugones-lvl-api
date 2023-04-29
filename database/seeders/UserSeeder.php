<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\User;


use Illuminate\Support\Facades\DB;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        /*DB::table('Usuaris')->insert([
            'uid' => 'zoZjk0pFEqOFg3moSiirsg0PyjH2',
            'displayName' => 'Chumy',
            'email' => 'chasnout@gmail.com',

        ]);*/

        $usuaris = [
            [
                'uid' => 'zoZjk0pFEqOFg3moSiirsg0PyjH2',
                'displayName' => 'Chumy',
                'email' => 'chasnout@gmail.com',
                'rol' => 3,
                'photoUrl' => 'https://lh3.googleusercontent.com/a/AEdFTp6h_RyAf69jqCqo8xNiKUxf0BiV0FoDqSGKBDb-=s96-c',      
            ],
            [
                'uid' => 'GDL9LkGTmNWkNRnM4rzmspMN0Qa2',
                'displayName' => 'Xavi PSX',
                'email' => 'xavisp@gmail.com',
                'rol' => 1,
                'photoUrl' => 'https://lh3.googleusercontent.com/a/AEdFTp5mfGfnQKF8aj4LaWAt1RAvwqPUBA3WCtWiF5-ycoI=s96-c',      
            ],
            [
                'uid' => 'JkDKNLm1Z8NSF372iolow9BgrFp1',
                'displayName' => 'NEUS ARTIGA GALINDO',
                'email' => 'nartiga3@xtec.cat',
                'rol' => 1,
                'photoUrl' => 'https://lh3.googleusercontent.com/a/AEdFTp68kbbMMm9ksnK6yn8s2Krrn5iBvVTLiqUDLqlKGw=s96-c',      
            ],
        ];

       foreach ($usuaris as $usuari) {
           User::create($usuari);
       }

        DB::table('personal_access_tokens')->insert([
            'id' => '1',
            'tokenable_type' => 'App\Models\User',
            'tokenable_id' => 'zoZjk0pFEqOFg3moSiirsg0PyjH2',
            'name' => 'auth_token',
            'token' => '57103454145c2917742a8d0be958265184516b7c2769ab52066ce323704eee88',
            'abilities' => '["*"]',
        ]);

        DB::table('personal_access_tokens')->insert([
            'id' => '2',
            'tokenable_type' => 'App\Models\User',
            'tokenable_id' => 'zoZjk0pFEqOFg3moSiirsg0PyjH2',
            'name' => 'auth_token',
            'token' => '0761b7bea95f49dcb4ff4c6c197f7d341a9bf5f28299a5f453af598a69f4a454',
            'abilities' => '["*"]',
        ]);
    }
}
