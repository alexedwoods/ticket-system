<?php

namespace Tests\Feature\Tickets;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GenerateTicketCommandTest extends TestCase
{
    public function test_can_generate_ticket_command(): void
    {
        $this->seed();

        $this->artisan('app:generate-ticket')
            ->expectsOutputToContain('Generated ticket - ID:')
            ->assertExitCode(0);
    }
}
