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
                'ten' => 'Audi',
                'logo' => 'logoaudi.png',
            ],
            [
                'ten' => 'BMW',
                'logo' => 'logobmw.png',
            ],
            [
                'ten' => 'Chevrolet',
                'logo' => 'logochevrolet.png',
            ],
            [
                'ten' => 'Ford',
                'logo' => 'logoford.png',
            ],
            [
                'ten' => 'Honda',
                'logo' => 'logohonda.png',
            ],
            [
                'ten' => 'Hyundai',
                'logo' => 'logohyundai.png',
            ],
            [
                'ten' => 'Kia',
                'logo' => 'logokia.png',
            ],
            [
                'ten' => 'LandRover',
                'logo' => 'logolandrover.png',
            ],
            [
                'ten' => 'Dongfeng',
                'logo' => 'logodongfeng.png',
            ],
            [
                'ten' => 'Lexus',
                'logo' => 'logolexus.png',
            ],
            [
                'ten' => 'Mazda',
                'logo' => 'logomazda.png',
            ],
            [
                'ten' => 'Mercedes-Benz',
                'logo' => 'logomercedes.png',
            ],
            [
                'ten' => 'Nissan',
                'logo' => 'logonissan.png',
            ],
            [
                'ten' => 'Suzuki',
                'logo' => 'logosuzuki.png',
            ],
            [
                'ten' => 'Thaco',
                'logo' => 'logothaco.png',
            ],
            [
                'ten' => 'Toyota',
                'logo' => 'logotoyota.png',
            ],
            [
                'ten' => 'Volkswagen',
                'logo' => 'logovolkswagen.png',
            ],
            [
                'ten' => 'Peugeot',
                'logo' => 'logopeugeot.png',
            ],
        ];
        DB::table('brands')->insert($brands);
    }
}
