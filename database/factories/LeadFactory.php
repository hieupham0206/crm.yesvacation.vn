<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Lead::class, function (Faker $faker) {
    return [
        'name'        => $faker->name,
        'email'       => $faker->email,
        'gender'      => $faker->randomElement([1, 2]),
        'birthday'    => $faker->date('d-m-Y'),
        'address'     => $faker->streetAddress,
        'province_id' => function () use ($faker) {
            return $faker->randomElement(\App\Models\Province::get(['id'])->pluck('id')->toArray());
        },
        'phone'       => $faker->phoneNumber,
        'title'       => $faker->randomElement(['Anh', 'Chị'])
    ];
});
