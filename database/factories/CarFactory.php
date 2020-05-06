<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Car;
use App\Location;
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

$factory->define(Car::class, function (Faker $faker) {
    $created_at = $faker->dateTimeBetween($startDate = '-12 months', $endDate = 'now', $timezone = null);
    $ngaydang = $faker->dateTimeInInterval($startDate = $created_at, $interval = '+ 7 days', $timezone = null);
    $ngayketthuc = $faker->dateTimeInInterval($startDate = $ngaydang, $interval = '+ 90 days', $timezone = null);

    $difference = $ngaydang->diff($ngayketthuc);
    $days = $difference->format('%a');
    $cost = $days * 1000;
    $namsx = $faker->year($max = 'now');
    return [
        'ten' => $faker->sentence($nbWords = 7, $variableNbWords = true),
        'gia' => $faker->numberBetween($min = 100, $max = 9000) * 1000000,
        'types_id' => App\Type::all()->random()->id,
        'colors_id' => App\Color::all()->random()->id,
        'conditions_id' => App\Condition::all()->random()->id,
        'origins_id' => App\Origin::all()->random()->id,
        'transmissions_id' => App\Transmission::all()->random()->id,
        'fuels_id' => App\Fuel::all()->random()->id,
        'locations_id' => App\Location::all()->random()->id,
        'furnitures_id' => App\Color::all()->random()->id,
        'styles_id' => App\Style::all()->random()->id,
        'users_id' => App\User::all()->random()->id,
        'namsx' => $namsx,
        'doixe' => $namsx,
        'socua' => $faker->numberBetween($min = 2, $max = 5),
        'sochongoi' => $faker->randomElement($array = array (1,2,4,7,9,12,16,45)),
        'kichthuoc' => '4425x1700x1465',
        'cannang' => $faker->numberBetween($min = 1000, $max = 3000),
        'dungtich' => $faker->numberBetween($min = 1000, $max = 3000),
        'phanh' => 'ABS, EBD, BA',
        'giamxoc' => 'Mc Pherson',
        'lopxe' => '185/60',
        'mota' => $faker->realText($maxNbChars = 250, $indexSize = 2),
        'trangthai' => $faker->randomElement($array = array (0, 2, 3)),
        'ngaydang' => $ngaydang,
        'ngayketthuc' => $ngayketthuc,
        'phi' => $cost,
        'created_at' => $created_at,
        'updated_at' => $created_at,
    ];
});
