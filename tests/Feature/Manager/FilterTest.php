<?php

namespace Tests\Feature\Manager;

use App\Models\Comment;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilterTest extends TestCase
{
    use DatabaseTransactions;

    private $client;
    private $manager;

    public function setUp(): void
    {
        parent::setUp();

        $this->client = factory(User::class)->create(['role' => User::ROLE_CLIENT]);
        $this->manager = factory(User::class)->create(['role' => User::ROLE_MANAGER]);
    }

    public function testAnswered()
    {
        $ticket = factory(Ticket::class)->create(['status' => Ticket::STATUS_NEW]);

        self::assertFalse(Ticket::answered()->get()->contains($ticket));
        self::assertTrue(Ticket::notAnswered()->get()->contains($ticket));

        factory(Comment::class)->create([
            'user_id' => $this->manager->id,
            'ticket_id' => $ticket->id,
        ]);

        self::assertTrue(Ticket::answered()->get()->contains($ticket));
        self::assertFalse(Ticket::notAnswered()->get()->contains($ticket));
    }

    public function testAnsweredWhenOnlyClientCommented()
    {
        /** @var Ticket $ticket */
        $ticket = factory(Ticket::class)->create(['status' => Ticket::STATUS_NEW]);
        factory(Comment::class)->make([
            'user_id' => $this->client->id,
            'ticket_id' => $ticket->id,
        ]);

        self::assertTrue(Ticket::notAnswered()->get()->contains($ticket));
        self::assertFalse(Ticket::answered()->get()->contains($ticket));
    }

    public function testByStatus()
    {
        $activeTicket = factory(Ticket::class)->create(['status' => Ticket::STATUS_NEW]);
        $closedTicket = factory(Ticket::class)->create(['status' => Ticket::STATUS_CLOSED]);

        self::assertTrue(Ticket::active()->get()->contains($activeTicket));
        self::assertFalse(Ticket::closed()->get()->contains($activeTicket));

        self::assertFalse(Ticket::active()->get()->contains($closedTicket));
        self::assertTrue(Ticket::closed()->get()->contains($closedTicket));
    }

    public function testViewed()
    {
        $ticket = factory(Ticket::class)->create(['status' => Ticket::STATUS_NEW]);

        self::assertTrue(Ticket::viewedBy($this->manager)->get()->isEmpty());
        self::assertTrue(Ticket::notViewedBy($this->manager)->get()->contains($ticket));

        $this->actingAs($this->manager)
            ->get(route('tickets.show', $ticket));

        self::assertEquals(1, Ticket::viewedBy($this->manager)->count());
        self::assertEquals($ticket->id, Ticket::viewedBy($this->manager)->first()->id);
    }
}
