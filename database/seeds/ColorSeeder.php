<?php

use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $colors = [
            [
                'ten' => 'Đen',
                'rgb' => 'color-den.png'
            ],
            [
                'ten' => 'Bạc',
                'rgb' => 'color-bac.png'
            ],
            [
                'ten' => 'Nâu',
                'rgb' => 'color-nau.png'
            ],
            [
                'ten' => 'Xanh lam',
                'rgb' => 'color-lam.png'
            ],
            [
                'ten' => 'Kem (Be)',
                'rgb' => 'color-kem.png'
            ],
            [
                'ten' => 'Hồng',
                'rgb' => 'color-hong.png'
            ],
            [
                'ten' => 'Hai màu',
                'rgb' => 'color-2mau.png'
            ],
            [
                'ten' => 'Trắng',
                'rgb' => 'color-trang.png'
            ],
            [
                'ten' => 'Đỏ',
                'rgb' => 'color-do.png'
            ],
            [
                'ten' => 'Xanh lục',
                'rgb' => 'color-luc.png'
            ],
            [
                'ten' => 'Vàng',
                'rgb' => 'color-vang.png'
            ],
            [
                'ten' => 'Xám (Ghi)',
                'rgb' => 'color-xam.png'
            ],
            [
                'ten' => 'Cam',
                'rgb' => 'color-cam.png'
            ],
            [
                'ten' => 'Màu khác',
                'rgb' => 'color-khac.png'
            ],
        ];

        DB::table('colors')->insert($colors);
    }
}
