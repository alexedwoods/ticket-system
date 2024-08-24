<?php

namespace Tests\Feature\Tickets;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GenerateTicketCommandTest extends TestCase
{
    public function test_generate_ticket_command_can_be_generated(): void
    {
        $this->seed();

        $this->artisan('app:generate-ticket')
            ->expectsOutputToContain('Generated ticket - ID:')
            ->assertExitCode(0);
    }
}
