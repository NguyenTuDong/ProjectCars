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
                'slug' => 'developer',
                'name' => 'Developer',
            ],
            [
                'slug' => 'manager',
                'name' => 'Manager',
            ],
            [
                'slug' => 'admin',
                'name' => 'Admin',
            ],
        ];

        DB::table('roles')->insert($roles);
    }
}
