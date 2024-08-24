<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Console\Command;

class GenerateTicket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-ticket';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a new ticket with dummy data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $ticket = new Ticket();
            $ticket->subject = fake()->word;
            $ticket->content = fake()->sentence(50);
            $ticket->user_id = fake()->numberBetween(1,2);
            $ticket->status = false;
            $ticket->save();
            $this->info('Generated ticket - ID: ' . $ticket->id);
        } catch (\Throwable $th) {
            $this->error($th->getMessage());
        }
    }
}
