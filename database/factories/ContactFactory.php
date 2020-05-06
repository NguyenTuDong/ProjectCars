<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Contact;
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

$factory->define(Contact::class, function (Faker $faker) {
    $created = $faker->dateTimeBetween($startDate = '-12 months', $endDate = 'now', $timezone = null);
    return [
        'users_id' => App\User::all()->random()->id,
        'ten' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'sdt' => $faker->e164PhoneNumber,
        'noidung' => $faker->realText($maxNbChars = 250, $indexSize = 2),
        'created_at' => $created,
        'updated_at' => $created,
    ];
});
