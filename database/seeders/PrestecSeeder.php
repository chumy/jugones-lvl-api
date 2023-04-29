<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\Prestec;

class PrestecSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coleccions = [

            [
                'jocId' => '80e4b490-3469-4cc6-81e0-778ca38d2431',
                'uid' => 'zoZjk0pFEqOFg3moSiirsg0PyjH2',
                'prestecId' => '9904662a-c8f7-43d2-bece-c9699c7fccb1',
                'dataInici' => '2023-04-25',
            ],
            
        ];

       foreach ($coleccions as $item) {
           Prestec::create($item);
       }

    }
}
