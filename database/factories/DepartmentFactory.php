<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Department::class, function (Faker $faker) {
    $provinceId = $faker->randomElement(\App\Models\Province::get(['id'])->pluck('id')->toArray());

    return [
        'name'        => 'DP' . $faker->randomNumber(),
        'province_id' => $provinceId
    ];
});
