<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\Partida;

class PartidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $coleccions = [

            [
                'partidaId' => '046ac2d8-51cb-4706-bbe2-72f9fb17e65b',
                'data' => null,
                'numJugadors' => '2',
                'bggId' => '312251',
                'organitzador' => 'zoZjk0pFEqOFg3moSiirsg0PyjH2',
                'oberta' => 1,
                'comentaris' => 'test',

            ],
            [
                'partidaId' => '91363107-51e8-44d6-a5d0-10adb6724cb0',
                'data' => '2023-04-12 22:15:00',
                'numJugadors' => '6',
                'bggId' => '312675',
                'organitzador' => 'zoZjk0pFEqOFg3moSiirsg0PyjH2',
                'oberta' => 1,
                'comentaris' => '',

            ],
            [
                'partidaId' => 'ce72d352-9f69-4b57-b7f1-350c6d173f91',
                'data' => '2023-04-29 11:45:00',
                'numJugadors' => '5',
                'bggId' => '141517',
                'organitzador' => 'zoZjk0pFEqOFg3moSiirsg0PyjH2',
                'oberta' => 1,
                'comentaris' => 'test 2',

            ],
            
        ];

       foreach ($coleccions as $item) {
           Partida::create($item);
       }

    }
}
