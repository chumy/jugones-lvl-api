<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\Joc;

class JocSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coleccions = [
            [
                'name' => 'Fort',
                'bggId' => '296912',
                'expansio' => '0',
                'minJugadors' => '2',
                'maxJugadors' => '4',
                'dificultat' => '2.4187',
                'duracio' => '40',
                'edat' => '10',
                'imatge' => 'https://cf.geekdo-images.com/hAsqLdANmtExR5Zi41v94Q__thumb/img/YqmIsRVLpQqM-r5i1rsN91Q6fzg=/fit-in/200x150/filters:strip_icc()/pic5241325.png',
            ],
            [
                
                'name' => 'Heat: Pedal to the Metal',
                'bggId' => '303551',
                'expansio' => '0',
                'minJugadors' => '2',
                'maxJugadors' => '2',
                'dificultat' => '3.8302',
                'duracio' => '120',
                'edat' => '12',
                'imatge' => 'https://cf.geekdo-images.com/sR9vKUFfimiNWW7dOSkBMg__thumb/img/rg7Lwz8yf4l11GEPXGF7ACHsBSg=/fit-in/200x150/filters:strip_icc()/pic5264401.jpg',
            ],
            [
                
                'name' => 'Polis',
                'bggId' => '366013',
                'expansio' => 0,
                'minJugadors' => '1',
                'maxJugadors' => '6',
                'dificultat' => '2.1900',
                'duracio' => '60',
                'edat' => '10',
                'imatge' => 'https://cf.geekdo-images.com/-vOrd4bOspibyohYExLqWg__thumb/img/2GbaKvYOzWIxfgbYTk2R9puiyzo=/fit-in/200x150/filters:strip_icc()/pic6940449.png',
            ],
            [
                
                'name' => 'A Study in Emerald',
                'bggId' => '141517',
                'expansio' => 0,
                'minJugadors' => '2',
                'maxJugadors' => '5',
                'dificultat' => '3.4538',
                'duracio' => '90',
                'edat' => '10',
                'imatge' => 'https://cf.geekdo-images.com/W_t-KinDa1Ag3JsZrMWMVw__thumb/img/rzgzAAHJZFQ7rSIHxWwiKUJu9hY=/fit-in/200x150/filters:strip_icc()/pic1638689.jpg',
            ],
            [
                
                'name' => 'Curious Cargo',
                'bggId' => '312251',
                'expansio' => 0,
                'minJugadors' => '2',
                'maxJugadors' => '2',
                'dificultat' => '3.2375',
                'duracio' => '60',
                'edat' => '12',
                'imatge' => 'https://cf.geekdo-images.com/4EX-XaYzUK21jAl5L3KEUA__thumb/img/ad5F_l7jCq9xRB3uv0fL8_9hRag=/fit-in/200x150/filters:strip_icc()/pic5478785.jpg',
            ],
            [
                
                'name' => 'Pole Position',
                'bggId' => '312675',
                'expansio' => 0,
                'minJugadors' => '1',
                'maxJugadors' => '6',
                'dificultat' => '3.0000',
                'duracio' => '180',
                'edat' => '14',
                'imatge' => 'https://cf.geekdo-images.com/dkqNBYiETbDGSJbZSVZhgg__thumb/img/Ip3m_VIDN33t0KUfcfPrNLpeBZY=/fit-in/200x150/filters:strip_icc()/pic6858277.jpg',
            ],
            
        ];

       foreach ($coleccions as $item) {
           Joc::create($item);
       }
    }
}
