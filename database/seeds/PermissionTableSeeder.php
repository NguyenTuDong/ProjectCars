<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'slug' => 'create-brands',
                'name' => 'Create Brands',
            ],
            [
                'slug' => 'edit-brands',
                'name' => 'Edit Brands',
            ],
            [
                'slug' => 'delete-brands',
                'name' => 'Delete Brands',
            ],
        ];

        DB::table('permissions')->insert($permissions);
    }
}