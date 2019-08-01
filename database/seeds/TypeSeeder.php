<?php

use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [


            //Audi
            [
                'brands_id' => 1,
                'ten' => 'A1',
            ],
            [
                'brands_id' => 1,
                'ten' => 'A2',
            ],
            [
                'brands_id' => 1,
                'ten' => 'A3',
            ],
            

            //BMW
            [
                'brands_id' => 2,
                'ten' => 'M Couper',
            ],
            [
                'brands_id' => 2,
                'ten' => 'M2',
            ],
            [
                'brands_id' => 2,
                'ten' => 'M3',
            ],
        ];

        DB::table('types')->insert($types);
    }
}
