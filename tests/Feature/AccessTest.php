<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccessTest extends TestCase
{
    public function testGuestNowAllowed()
    {
        $this->get('/')
            ->assertRedirect(route('login'));
    }
}
