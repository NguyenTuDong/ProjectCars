<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Convenientcar;
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

$factory->define(Convenientcar::class, function (Faker $faker) {
    return [
        'cars_id' => App\Car::all()->random()->id,
        'convenients_id' => App\Convenient::all()->random()->id,
    ];
});
