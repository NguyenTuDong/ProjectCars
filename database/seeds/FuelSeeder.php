<?php

use Illuminate\Database\Seeder;

class FuelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fuels = [
            [
                'ten' => 'Xăng',
            ],
            [
                'ten' => 'Diesel',
            ],
            [
                'ten' => 'Hybrid',
            ],
            [
                'ten' => 'Điện',
            ],
            [
                'ten' => 'Loại khác',
            ],
        ];

        DB::table('fuels')->insert($fuels);
    }
}
