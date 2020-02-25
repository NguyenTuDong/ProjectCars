<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $admins = [
            [
                'ten' => 'Dong Nguyen',
                'email' => 'tudong.ng@gmail.com',
                'password' => bcrypt('password'),
            ],
        ];
        DB::table('admins')->insert($admins);

        $this->call([
            RegionSeeder::class,
            LocationSeeder::class,
            BrandSeeder::class,
            TypeSeeder::class,
            ColorSeeder::class,
            ConditionSeeder::class,
            FuelSeeder::class,
            OriginSeeder::class,
            TransmissionSeeder::class,
            StyleSeeder::class,
            ConvenientSeeder::class,
            PermissionTableSeeder::class,
            RoleTableSeeder::class,
            AdminTableSeeder::class,
        ]);

        factory(App\User::class, 50)->create();
        factory(App\Car::class, 300)->create()->each(function ($car) {
                $car->convenientcars()->createMany(
                    factory(App\Convenientcar::class, 2)->make([
                        'cars_id' => $car->id,
                    ])->toArray()
                );
            });
        factory(App\Contact::class, 200)->create();
    }
}
