<?php

namespace Tests\Feature\Tickets;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(['email' => 'test@example.com']);
        Ticket::factory()->count(5)->create(['user_id' => $this->user->id, 'status' => false]);
        Ticket::factory()->count(3)->create(['user_id' => $this->user->id, 'status' => true]);
    }

    public function test_index_shows_all_tickets(): void
    {
        $response = $this->actingAs($this->user)->get(route('tickets.index'));

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'status']
                ],
                'links',
                'meta'
            ]);
    }

    public function test_open_shows_all_open_tickets(): void
    {
        $response = $this->actingAs($this->user)->get(route('tickets.open'));

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'status']
                ],
                'links',
                'meta'
            ])
            ->assertJsonFragment(['status' => false]);
    }

    public function test_closed_shows_all_closed_tickets(): void
    {
        $response = $this->actingAs($this->user)->get(route('tickets.closed'));

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'status']
                ],
                'links',
                'meta'
            ])
            ->assertJsonFragment(['status' => true]);
    }

    public function test_user_shows_all_users_tickets(): void
    {
        $response = $this->actingAs($this->user)->get('/api/users/test@example.com/tickets');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'status']
                ],
                'links',
                'meta'
            ]);
    }

    public function test_stats_shows_all_stats(): void
    {
        $response = $this->actingAs($this->user)->get(route('tickets.stats'));

        $response->assertStatus(200)
            ->assertJsonCount(4)
            ->assertJsonStructure([
                'total_tickets',
                'total_unprocessed_tickets',
                'user_with_most_tickets',
                'latest_ticket_created_at'
            ]);
    }
}
