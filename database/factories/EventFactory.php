<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Event;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
    $start = $faker->dateTimeThisMonth;
    $hostCount = User::Role(config('role.doctor.value'))->count();

    if ($hostCount < 1) {
        return [
            'start' => $start,
            'title' => $faker->word,
        ];
    }

    $i = rand(0, $hostCount - 1);
    $hosts = User::Role(config('role.doctor.value'))->get();
    $host = $hosts[$i];
    $clinicID = $host->clinic_id;

    $guests = User::Role(config('role.patient.value'))->where('clinic_id', $clinicID)->get();
    if ($guests->count() < 1) {
        return [
            'start' => $start,
            'title' => $faker->word,
        ];
    }

    $i = rand(0, $guests->count() - 1);
    $guest = $guests[$i];

    return [
        'start' => $start,
        'title' => $faker->word,
        'host_id' => $host->id,
        'guest_id' => $guest->id,
    ];
});
