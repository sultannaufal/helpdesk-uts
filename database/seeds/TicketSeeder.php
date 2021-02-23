<?php

use App\Models\Comment;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $managers = factory(User::class, 3)->create(['role' => User::ROLE_MANAGER]);

        factory(User::class, 20) // Создать пользователей
            ->create()
            ->each(function (User $client) use ($managers) {
                $tickets = factory(Ticket::class, rand(1, 13)) // И на каждого создать рандомное количество заявок
                    ->create([
                        'client_id' => $client,
                        'manager_id' => function (array $ticket) use ($managers) { // Назначить менеджера из созданных выше
                            // У новой заявки еще нет менеджера, так что назначить по условию
                            return $ticket['status'] === Ticket::STATUS_NEW
                                ? null
                                : $managers->random();
                        }
                    ]);

                // Добавить в заявки комментарии
                $tickets->each(function (Ticket $ticket) use ($client, $managers) {
                    $possibleCommentAuthors = array_merge([$client], $managers->toArray());

                    if (! $ticket->isNew()) {
                        factory(Comment::class, rand(0, 5))->create([
                            'ticket_id' => $ticket,
                            'user_id' => array_rand($possibleCommentAuthors),
                        ]);
                    }
                });
            });
    }
}
