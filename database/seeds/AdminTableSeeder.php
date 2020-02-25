<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;
use App\Admin;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dev_role = Role::where('slug','developer')->first();
        $manager_role = Role::where('slug', 'manager')->first();
        $admin_role = Role::where('slug', 'admin')->first();

        $create_perm = Permission::where('slug','create-brands')->first();
        $edit_perm = Permission::where('slug','edit-brands')->first();
        $delete_perm = Permission::where('slug','delete-brands')->first();

        $developer = new Admin();
        $developer->ten = 'I am developer';
        $developer->email = 'dev@test.com';
        $developer->password = bcrypt('123456');
        $developer->save();
        $developer->roles()->attach($dev_role);
        $developer->permissions()->attach($create_perm);

        $manager = new Admin();
        $manager->ten = 'I am manager';
        $manager->email = 'manager@test.com';
        $manager->password = bcrypt('123456');
        $manager->save();
        $manager->roles()->attach($manager_role);
        $manager->permissions()->attach($edit_perm);

        $admin = new Admin();
        $admin->ten = 'I am admin';
        $admin->email = 'admin@test.com';
        $admin->password = bcrypt('123456');
        $admin->save();
        $admin->roles()->attach($admin_role);
        $admin->permissions()->attach($delete_perm);
    }
}
