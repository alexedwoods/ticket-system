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
        $ticket = Ticket::where('status', false)->oldest()->first();
        $ticket->status = true;
        $ticket->save();
    }
}
