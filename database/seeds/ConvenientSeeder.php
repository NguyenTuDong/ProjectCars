<?php

use Illuminate\Database\Seeder;

class ConvenientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $convenients = [
            [
                'ten' => 'Túi khí cho người lái',
            ],
            [
                'ten' => 'Túi khí phía trước',
            ],
            [
                'ten' => 'Túi khí phía sau',
            ],
            [
                'ten' => 'Chốt cửa an toàn',
            ],
            [
                'ten' => 'Khóa động cơ',
            ],
            [
                'ten' => 'Hệ thống báo trộm',
            ],
            [
                'ten' => 'Chống bó cứng (Abs)',
            ],
            [
                'ten' => 'Trợ lực phanh (Eba)',
            ],
            [
                'ten' => 'Hỗ trợ cảnh báo lùi',
            ],
            [
                'ten' => 'Đèn sương mù',
            ],
            [
                'ten' => 'Kính chỉnh điện',
            ],
            [
                'ten' => 'Tay lái trợ lực',
            ],
            [
                'ten' => 'Điều hòa trước',
            ],
            [
                'ten' => 'Màn hình LCD',
            ],
        ];

        DB::table('convenients')->insert($convenients);
    }
}
