<?php

namespace Feature\Tickets;

use App\Models\Ticket;
use Tests\TestCase;

class ProcessTicketCommandTest extends TestCase
{
    public function test_process_ticket_command_can_be_processed(): void
    {
        Ticket::factory()->create(['status' => false]);

        $this->artisan('app:process-ticket')
            ->expectsOutputToContain('Processed ticket ID:')
            ->assertExitCode(0);
    }

    public function test_oldest_ticket_is_the_processed_ticket(): void
    {
        Ticket::factory()->create(['status' => false, 'created_at' => now()->subDays(2)]);
        $oldestTicket = Ticket::factory()->create(['status' => false, 'created_at' => now()->subDays(3)]);
        Ticket::factory()->create(['status' => true, 'created_at' => now()->subDays(4)]);

        $this->artisan('app:process-ticket')
            ->expectsOutput('Processed ticket ID: ' . $oldestTicket->id)
            ->assertExitCode(0);

        $this->assertTrue($oldestTicket->fresh()->status);
    }
}
