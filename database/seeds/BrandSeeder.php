<?php

use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = [
            [
                'id' => 1,
                'ten' => 'Audi',
                'logo' => 'logoaudi.png',
            ],
            [
                'id' => 2,
                'ten' => 'BMW',
                'logo' => 'logobmw.png',
            ],
            [
                'id' => 3,
                'ten' => 'Chevrolet',
                'logo' => 'logochevrolet.png',
            ],
            [
                'id' => 4,
                'ten' => 'Ford',
                'logo' => 'logoford.png',
            ],
            [
                'id' => 5,
                'ten' => 'Honda',
                'logo' => 'logohonda.png',
            ],
            [
                'id' => 6,
                'ten' => 'Hyundai',
                'logo' => 'logohyundai.png',
            ],
            [
                'id' => 7,
                'ten' => 'Kia',
                'logo' => 'logokia.png',
            ],
            [
                'id' => 8,
                'ten' => 'LandRover',
                'logo' => 'logolandrover.png',
            ],
            [
                'id' => 9,
                'ten' => 'Dongfeng',
                'logo' => 'logodongfeng.png',
            ],
            [
                'id' => 10,
                'ten' => 'Lexus',
                'logo' => 'logolexus.png',
            ],
            [
                'id' => 11,
                'ten' => 'Mazda',
                'logo' => 'logomazda.png',
            ],
            [
                'id' => 12,
                'ten' => 'Mercedes-Benz',
                'logo' => 'logomercedes.png',
            ],
            [
                'id' => 13,
                'ten' => 'Nissan',
                'logo' => 'logonissan.png',
            ],
            [
                'id' => 14,
                'ten' => 'Suzuki',
                'logo' => 'logosuzuki.png',
            ],
            [
                'id' => 15,
                'ten' => 'Thaco',
                'logo' => 'logothaco.png',
            ],
            [
                'id' => 16,
                'ten' => 'Toyota',
                'logo' => 'logotoyota.png',
            ],
            [
                'id' => 17,
                'ten' => 'Volkswagen',
                'logo' => 'logovolkswagen.png',
            ],
            [
                'id' => 18,
                'ten' => 'Peugeot',
                'logo' => 'logopeugeot.png',
            ],
        ];
        DB::table('brands')->insert($brands);
    }
}
