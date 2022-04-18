<?php

namespace Tests\Unit\Models\User;

use App\Models\Ticket;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Gate;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use DatabaseTransactions;

    private $client;

    public function setUp(): void
    {
        parent::setUp();

        $this->client = factory(User::class)->create(['role' => User::ROLE_CLIENT]);
    }

    public function testClient()
    {
        $this->assertTrue($this->client->isClient());
        $this->assertFalse($this->client->isManager());
    }

    public function testGetLastTicket()
    {
        factory(Ticket::class)->create(['client_id' => $this->client->id]);
        $lastTicket = factory(Ticket::class)->create([
            'client_id' => $this->client->id,
            'created_at' => Carbon::now()->addHour(),
        ]);

        self::assertEquals($lastTicket->id, $this->client->getLastTicket()->id);
    }

    public function testCanCreateTicketOnceADAy()
    {
        $this->actingAs($this->client)
            ->assertTrue(Gate::allows('create-ticket'), 'Kalau belum pernah buat sebelumnya');

        $ticket = factory(Ticket::class)->create(['client_id' => $this->client->id]);

        $this->actingAs($this->client)
            ->assertFalse(Gate::allows('create-ticket'), 'Pernah buat');

        $initialCreatedAt = $ticket->created_at;

        $ticket->created_at = $initialCreatedAt->copy()->subHour();
        $ticket->save();

        $this->actingAs($this->client)
            ->assertFalse(Gate::allows('create-ticket'), 'Dalam 1 jam');

        $ticket->created_at = $initialCreatedAt->copy()->subHours(23);
        $ticket->save();

        $this->actingAs($this->client)
            ->assertFalse(Gate::allows('create-ticket'), 'Setelah 23 jam');

        $ticket->created_at = $initialCreatedAt->copy()->subDay()->subSecond();
        $ticket->save();

        $this->actingAs($this->client)
            ->assertTrue(Gate::allows('create-ticket'), 'Dalam 1 hari lebih');
    }
}
