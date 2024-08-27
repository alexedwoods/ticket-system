<?php

namespace Tests\Feature\Tickets;

use Database\Seeders\UserSeeder;
use Tests\TestCase;

class GenerateTicketCommandTest extends TestCase
{
    public function test_generate_ticket_command_can_be_generated(): void
    {
        $this->seed(UserSeeder::class);

        $this->artisan('app:generate-ticket')
            ->expectsOutputToContain('Generated ticket - ID:')
            ->assertExitCode(0);
    }
}
