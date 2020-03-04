<?php

use Illuminate\Database\Seeder;

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
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'slug' => 'developer',
                'ten' => 'Developer',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'slug' => 'manager',
                'ten' => 'Manager',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'slug' => 'censor',
                'ten' => 'Censor',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'slug' => 'accountant',
                'ten' => 'Accountant',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'slug' => 'employee',
                'ten' => 'Employee',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ];

        DB::table('roles')->insert($roles);
    }
}
