<?php

use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions = [
            [
                'ten' => 'Miền Bắc',
            ],
            [
                'ten' => 'Miền Trung',
            ],
            [
                'ten' => 'Miền Nam',
            ],
        ];
        DB::table('regions')->insert($regions);
    }
}
