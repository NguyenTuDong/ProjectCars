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
        $admin_role = Role::where('slug', 'admin')->first();
        $dev_role = Role::where('slug','developer')->first();
        $manager_role = Role::where('slug', 'manager')->first();

        $all = Permission::get();
        $xem_dashboard = Permission::where('slug','xem-dashboard')->first();
        $quan_ly_danh_muc = Permission::where('slug','quan-ly-danh-muc')->first();
        $quan_ly_chuc_vu = Permission::where('slug','quan-ly-chuc-vu')->first();

        $admin_role->permissions()->attach($all);
        $dev_role->permissions()->attach($all);

        $developer = new Admin();
        $developer->ten = 'Dong Nguyen';
        $developer->email = 'tudong.ng@gmail.com';
        $developer->password = bcrypt('123456');
        $developer->save();
        $developer->roles()->attach($admin_role);
        $developer->permissions()->attach($xem_dashboard);

        $developer = new Admin();
        $developer->ten = 'I am developer';
        $developer->email = 'dev@test.com';
        $developer->password = bcrypt('123456');
        $developer->save();
        $developer->roles()->attach($dev_role);
        $developer->permissions()->attach($xem_dashboard);

        $manager = new Admin();
        $manager->ten = 'I am manager';
        $manager->email = 'manager@test.com';
        $manager->password = bcrypt('123456');
        $manager->save();
        $manager->roles()->attach($manager_role);
        $manager->permissions()->attach($xem_dashboard);

        $admin = new Admin();
        $admin->ten = 'I am admin';
        $admin->email = 'admin@test.com';
        $admin->password = bcrypt('123456');
        $admin->save();
        $admin->roles()->attach($admin_role);
        $admin->permissions()->attach($xem_dashboard);
    }
}
