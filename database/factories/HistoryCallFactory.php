<?php

use Faker\Generator as Faker;

$factory->define(App\Models\HistoryCall::class, function (Faker $faker) {
    $userId = $faker->randomElement(\App\Models\User::get(['id'])->pluck('id')->toArray());
    $leadId = $faker->randomElement(\App\Models\Lead::get(['id'])->pluck('id')->toArray());



    return [
        'user_id'      => function () use ($faker) {
            return $faker->randomElement(\App\Models\User::get(['id'])->pluck('id')->toArray());
        },
        'lead_id'      => function () use ($faker) {
            return $faker->randomElement(\App\Models\Lead::get(['id'])->pluck('id')->toArray());
        },
        'member_id'    => null,
        'type'         => $faker->randomElement([1, 2, 3, 4]),
        'time_of_call' => $faker->numberBetween(100, 3000),
        'name'         => $faker->name,
        'phone'        => $faker->phoneNumber,
    ];
});
