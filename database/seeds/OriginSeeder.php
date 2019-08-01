<?php

use Illuminate\Database\Seeder;

class OriginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $origins = [
            [
                'ten' => 'Trong nước',
            ],
            [
                'ten' => 'Nhập khẩu',
            ],
        ];

        DB::table('origins')->insert($origins);
    }
}
