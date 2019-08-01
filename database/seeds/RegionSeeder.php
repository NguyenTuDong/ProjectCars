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
                'id' => 1,
                'ten' => 'Miền Bắc',
            ],
            [
                'id' => 2,
                'ten' => 'Miền Trung',
            ],
            [
                'id' => 3,
                'ten' => 'Miền Nam',
            ],
        ];
        DB::table('regions')->insert($regions);
    }
}
