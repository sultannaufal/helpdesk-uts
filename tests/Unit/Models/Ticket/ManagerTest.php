<?php

namespace Tests\Unit\Models\Ticket;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManagerTest extends TestCase
{
    use RefreshDatabase;

    public function testAssignManager()
    {
        $manager = factory(User::class)->create(['role' => User::ROLE_MANAGER]);

        /** @var Ticket $ticket */
        $ticket = factory(Ticket::class)->make([
            'status' => Ticket::STATUS_NEW,
            'manager_id' => null,
        ]);

        $this->assertFalse($ticket->hasManager());

        $ticket->assignManager($manager);

        $this->assertTrue($ticket->hasManager());
        $this->assertTrue($ticket->isInProgress());
    }

    // Вполне вероятно что менеджера могут переназначить, но это отдельный разговор
    public function testAlreadyAssigned()
    {
        $manager = factory(User::class)->create(['role' => User::ROLE_MANAGER]);
        $anotherManager = factory(User::class)->create(['role' => User::ROLE_MANAGER]);

        /** @var Ticket $ticket */
        $ticket = factory(Ticket::class)->make([
            'status' => Ticket::STATUS_NEW,
            'manager_id' => null,
        ]);

        $ticket->assignManager($manager);

        $this->expectExceptionMessage('The ticket already has an assigned manager');

        $ticket->assignManager($anotherManager);
    }

    public function testCannotAssignClient()
    {
        $client = factory(User::class)->create(['role' => User::ROLE_CLIENT]);

        /** @var Ticket $ticket */
        $ticket = factory(Ticket::class)->make([
            'status' => Ticket::STATUS_NEW,
            'manager_id' => null,
        ]);

        $this->expectExceptionMessage('User must have manager role');
        $ticket->assignManager($client);
    }

    public function testTicketShouldBeActive()
    {
        $manager = factory(User::class)->create(['role' => User::ROLE_MANAGER]);

        /** @var Ticket $ticket */
        $ticket = factory(Ticket::class)->make([
            'status' => Ticket::STATUS_CLOSED,
            'manager_id' => null,
        ]);

        $this->expectExceptionMessage('Ticket should be active');
        $ticket->assignManager($manager);
    }
}
