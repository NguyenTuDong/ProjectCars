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
            ],
            [
                'slug' => 'developer',
                'ten' => 'Developer',
            ],
            [
                'slug' => 'manager',
                'ten' => 'Manager',
            ],
            [
                'slug' => 'censor',
                'ten' => 'Censor',
            ],
            [
                'slug' => 'accountant',
                'ten' => 'Accountant',
            ],
            [
                'slug' => 'employee',
                'ten' => 'Employee',
            ],
        ];

        DB::table('roles')->insert($roles);
    }
}
