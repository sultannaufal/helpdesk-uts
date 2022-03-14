<?php

namespace Database\Factories;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Ticket;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Ticket::class, function (Faker $faker) {
    $client = factory(User::class)->create(['role' => User::ROLE_CLIENT]);

    return [
        'theme' => $faker->sentence,
        'content' => $faker->text,
        'status' => $faker->randomElement(array_keys(Ticket::getStatuses())),
        'client_id' => $client->id,
        'manager_id' => function (array $ticket) {
            return $ticket['status'] === Ticket::STATUS_NEW
                ? null
                : factory(User::class)->create(['role' => User::ROLE_MANAGER])->id;
        },
    ];
});
