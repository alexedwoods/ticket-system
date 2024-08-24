<?php

namespace Feature\Tickets;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProcessTicketCommandTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_process_ticket_command_can_be_processed(): void
    {
        $this->seed();

        $this->artisan('app:process-ticket')
            ->expectsOutputToContain('Processed ticket ID:')
            ->assertExitCode(0);
    }
}
