<?php

use Illuminate\Database\Seeder;

class ConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $conditions = [
            [
                'ten' => 'Mới',
            ],
            [
                'ten' => 'Đã qua sử dụng',
            ],
        ];

        DB::table('conditions')->insert($conditions);
    }
}
