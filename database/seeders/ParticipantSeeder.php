<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\Participant;

class ParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coleccions = [

            [
                'partidaId' => '046ac2d8-51cb-4706-bbe2-72f9fb17e65b',
                'soci' => 'zoZjk0pFEqOFg3moSiirsg0PyjH2',
                'propietario' => 1,
                'explicador' => 0,
                'need_explicacion' => 1,


            ],
            [
                'partidaId' => '91363107-51e8-44d6-a5d0-10adb6724cb0',
                'soci' => 'zoZjk0pFEqOFg3moSiirsg0PyjH2',
                'propietario' => 1,
                'explicador' => 1,
                'need_explicacion' => 0,


            ],

            
        ];


       foreach ($coleccions as $item) {
           Participant::create($item);
       }
    }
}
