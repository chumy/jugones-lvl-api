<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\Coleccio;

class ColeccioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coleccions = [
            [
                'jocId' => '5c57e0bc-be3b-485e-b88c-ad983ea5717d',
                'joc' => 'Fort',
                'bggId' => '296912',
                'tipologia' => '',
                'ambit' => '',
                'comentaris' => '',
            ],
            [
                'jocId' => '80e4b490-3469-4cc6-81e0-778ca38d2431',
                'joc' => 'Heat: Pedal to the Metal',
                'bggId' => '366013',
                'tipologia' => '',
                'ambit' => '',
                'comentaris' => '',
            ],
            [
                'jocId' => 'b49d4cbd-0a17-4270-a138-a882a91f7d96',
                'joc' => 'Polis',
                'bggId' => '303551',
                'tipologia' => '',
                'ambit' => '',
                'comentaris' => '',
            ],
            
        ];

       foreach ($coleccions as $item) {
           Coleccio::create($item);
       }

    }
}
