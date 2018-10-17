<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Callback::class, function (Faker $faker) {
    return [
        'user_id'           => function () use ($faker) {
            return $faker->randomElement(\App\Models\User::get(['id'])->pluck('id')->toArray());
        },
        'lead_id'           => function () use ($faker) {
            return $faker->randomElement(\App\Models\Lead::get(['id'])->pluck('id')->toArray());
        },
        'callback_datetime' => $faker->creditCardExpirationDate,
        'state'             => $faker->randomElement([-1, 1])
    ];
});
