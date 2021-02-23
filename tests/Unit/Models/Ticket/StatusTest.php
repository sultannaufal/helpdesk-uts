<?php

namespace Tests\Unit\Models\Ticket;

use App\Models\Ticket;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class StatusTest extends TestCase
{
    use DatabaseTransactions;

    public function testAssignment()
    {
        $ticket = factory(Ticket::class)->make([
            'status' => Ticket::STATUS_NEW,
        ]);

        $this->assertTrue($ticket->isNew());
        $this->assertFalse($ticket->isInProgress());

        $ticket->status = Ticket::STATUS_IN_PROGRESS;

        $this->assertFalse($ticket->isNew());
        $this->assertTrue($ticket->isInProgress());
    }

    public function testWrongAssignment()
    {
        $ticket = factory(Ticket::class)->make();
        $this->expectExceptionMessage('Wrong status');
        $ticket->status = 'wrong';
    }
}
