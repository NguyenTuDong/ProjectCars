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


        $admin = new Admin();
        $admin->ten = 'Admin';
        $admin->email = 'admin@test.com';
        $admin->email_verified_at = '2019-04-06 13:51:52';
        $admin->password = bcrypt('123456');
        $admin->created_at = '2019-04-06 13:51:52';
        $admin->updated_at = '2019-04-06 13:51:52';
        $admin->save();
        $admin->roles()->attach($admin_role);


        $developer = new Admin();
        $developer->ten = 'Developer';
        $developer->email = 'dev@test.com';
        $developer->email_verified_at = '2019-04-06 13:51:52';
        $developer->password = bcrypt('123456');
        $developer->created_at = '2019-04-06 13:51:52';
        $developer->updated_at = '2019-04-06 13:51:52';
        $developer->save();
        $developer->roles()->attach($dev_role);

        $manager = new Admin();
        $manager->ten = 'Manager';
        $manager->email = 'manager@test.com';
        $manager->email_verified_at = '2019-04-06 13:51:52';
        $manager->password = bcrypt('123456');
        $manager->created_at = '2019-04-06 13:51:52';
        $manager->updated_at = '2019-04-06 13:51:52';
        $manager->save();
        $manager->roles()->attach($manager_role);
    }
}
