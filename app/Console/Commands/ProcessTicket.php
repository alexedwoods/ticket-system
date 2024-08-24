<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use Illuminate\Console\Command;

class ProcessTicket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-ticket';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Marks the oldest open ticket as closed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $ticket = Ticket::where('status', false)->oldest()->first();

            if (!$ticket) {
                $this->info('No open tickets available.');
                return 0;
            }

            $ticket->status = true;
            $ticket->save();
            $this->info('Processed ticket ID: ' . $ticket->id);
            return 0;
        } catch (\Throwable $tr) {
            $this->error($tr->getMessage());
            return 1;
        }

    }
}
