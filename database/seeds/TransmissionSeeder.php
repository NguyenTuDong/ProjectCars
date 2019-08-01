<?php

use Illuminate\Database\Seeder;

class TransmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transmissions = [
            [
                'ten' => 'Số tay',
            ],
            [
                'ten' => 'Số tự động',
            ],
            [
                'ten' => 'Số hỗn hợp',
            ],
        ];

        DB::table('transmissions')->insert($transmissions);
    }
}
