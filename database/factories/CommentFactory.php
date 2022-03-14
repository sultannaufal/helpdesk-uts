<?php

namespace Database\Factories;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Comment;
use App\Models\Ticket;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    $user = factory(User::class)->create();
    $ticket = factory(Ticket::class)->create();

    return [
        'theme' => $faker->sentence,
        'content' => $faker->text,
        'user_id' => $user->id,
        'ticket_id' => $ticket->id,
    ];
});
