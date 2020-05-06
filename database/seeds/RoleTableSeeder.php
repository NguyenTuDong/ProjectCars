<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;


class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'slug' => 'admin',
                'ten' => 'Admin',
                'created_at' => '2019-04-06 13:51:52',
                'updated_at' => '2019-04-06 13:51:52',
            ],
            [
                'slug' => 'developer',
                'ten' => 'Developer',
                'created_at' => '2019-04-06 13:51:52',
                'updated_at' => '2019-04-06 13:51:52',
            ],
            [
                'slug' => 'manager',
                'ten' => 'Manager',
                'created_at' => '2019-04-06 13:51:52',
                'updated_at' => '2019-04-06 13:51:52',
            ],
            [
                'slug' => 'censor',
                'ten' => 'Censor',
                'created_at' => '2019-04-06 13:51:52',
                'updated_at' => '2019-04-06 13:51:52',
            ],
            [
                'slug' => 'accountant',
                'ten' => 'Accountant',
                'created_at' => '2019-04-06 13:51:52',
                'updated_at' => '2019-04-06 13:51:52',
            ],
            [
                'slug' => 'employee',
                'ten' => 'Employee',
                'created_at' => '2019-04-06 13:51:52',
                'updated_at' => '2019-04-06 13:51:52',
            ],
        ];

        DB::table('roles')->insert($roles);
    }
}
