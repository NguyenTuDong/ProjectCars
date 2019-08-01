<?php

use Illuminate\Database\Seeder;

class StyleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $styles = [
            [
                'ten' => 'Sedan',
                'hinhanh' => 'sedan.png',
            ],
            [
                'ten' => 'SUV',
                'hinhanh' => 'suv.png',
            ],
            [
                'ten' => 'Pick-up Truck',
                'hinhanh' => 'pickuptruck.png',
            ],
            [
                'ten' => 'CUV',
                'hinhanh' => 'cuv.png',
            ],
            [
                'ten' => 'MPV',
                'hinhanh' => 'mpv.png',
            ],
            [
                'ten' => 'Hatchback',
                'hinhanh' => 'hatchback.png',
            ],
            [
                'ten' => 'Truck',
                'hinhanh' => 'truck.png',
            ],
            [
                'ten' => 'Van/Minivan',
                'hinhanh' => 'van.png',
            ],
            [
                'ten' => 'City Car',
                'hinhanh' => 'citycar.png',
            ],
            [
                'ten' => 'Sport Car',
                'hinhanh' => 'sportcar.png',
            ],
            [
                'ten' => 'Coupe',
                'hinhanh' => 'coupe.png',
            ],
            [
                'ten' => 'Convertible',
                'hinhanh' => 'convertible.png',
            ],
            [
                'ten' => 'Wagon',
                'hinhanh' => 'wagon.png',
            ],
            [
                'ten' => 'Special Purpose',
                'hinhanh' => 'special.png',
            ],
        ];

        DB::table('styles')->insert($styles);
    }
}
