<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use App\Location;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    $date = $faker->dateTimeBetween($startDate = '-12 months', $endDate = 'now', $timezone = null);
    return [
        'ten' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => $date,
        'password' => bcrypt('123456'), // password
        'diachi' => $faker->address,
        'sdt' => $faker->e164PhoneNumber,
        'cmnd' => $faker->numberBetween($min = 100000000, $max = 999999999),
        'gioithieu' => $faker->realText($maxNbChars = 250, $indexSize = 2),
        'sodkkd' => $faker->numberBetween($min = 100000000, $max = 999999999),
        'mst' => $faker->numberBetween($min = 100000000, $max = 999999999),
        'locations_id' => Location::all()->random()->id,
        'remember_token' => Str::random(10),
        'created_at' => $date,
        'updated_at' => $date,
    ];
});
