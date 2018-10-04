<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Lead::class, function (Faker $faker) {
    return [
        'name'        => $faker->name,
        'email'       => $faker->email,
        'gender'      => $faker->randomElement([1,2]),
        'birthday'    => $faker->dateTimeBetween('-50 years', '18 years'),
        'address'     => $faker->streetAddress,
        'province_id' => function() use($faker) {
            return $faker->randomElement(\App\Models\Province::get(['id'])->pluck('id')->toArray());
        },
        'phone'       => $faker->phoneNumber,
    ];
});
