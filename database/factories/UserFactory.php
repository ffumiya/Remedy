<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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
    return [
        User::NAME => $faker->name,
        User::EMAIL => $faker->unique()->safeEmail,
        User::EMAIL_VERIFIED_AT => now(),
        User::PASSWORD => Hash::make('password'),
        USer::REMEMBER_TOKEN => Str::random(10),
        User::API_TOKEN => str_random(60),
        User::CLINIC_ID => rand(1, 3),
    ];
});
