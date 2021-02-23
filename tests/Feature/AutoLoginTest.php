<?php

namespace Tests\Feature;

use App\Models\AutoLogin;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AutoLoginTest extends TestCase
{
    use DatabaseTransactions;

    public function testAutoLogin()
    {
        $user = factory(User::class)->create();

        $this->assertGuest();

        $this->get(AutoLogin::createFor($user)->getRoute())
            ->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($user);
    }

    public function testAutoLoginForTicket()
    {
        $user = factory(User::class)->create();
        $ticket = factory(Ticket::class)->create(['status' => Ticket::STATUS_NEW]);

        $this->assertGuest();

        $this->get(AutoLogin::createFor($user)->getRouteForTicket($ticket))
            ->assertRedirect(route('tickets.show', $ticket));

        $this->assertAuthenticatedAs($user);
    }

    public function testExpired()
    {
        $user = factory(User::class)->create();

        $this->assertGuest();

        $expiredRoute = AutoLogin::createFor($user, now()->subDay())
            ->getRoute();

        $this->get($expiredRoute)
            ->assertUnauthorized();

        $this->assertGuest();
    }

    public function testUnsigned()
    {
        $user = factory(User::class)->create();

        $token = AutoLogin::createFor($user)->token;
        $this->assertGuest();

        $this->get(route('autologin', ['token' => $token]))
            ->assertUnauthorized();

        $this->assertGuest();
    }
}
