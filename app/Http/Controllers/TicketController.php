<?php

namespace App\Http\Controllers;

use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use App\Models\User;

class TicketController extends Controller
{
    public function index() {
        return TicketResource::collection(Ticket::paginate(3));
    }

    public function open() {
        return TicketResource::collection(Ticket::where('status', false)->paginate(3));
    }

    public function closed() {
        return TicketResource::collection(Ticket::where('status', true)->paginate(3));
    }

    public function userTickets($email) {
        $user = User::where('email', $email)->first();
        return TicketResource::collection($user->tickets()->paginate(3));
    }

    public function stats() {
        $ticketsCount = Ticket::all()->count();
        $unprocessedTicketsCount = Ticket::where('status', false)->count();
        $highestTicketCountUser = User::withCount('tickets')
            ->orderBy('tickets_count', 'desc')
            ->first();
        $latestTicketTimestamp = Ticket::where('status', false)->orderBy('created_at', 'desc')->first()->created_at;

        return response()->json([
            'total_tickets' => $ticketsCount,
            'total_unprocessed_tickets' => $unprocessedTicketsCount,
            'user_with_most_tickets' => $highestTicketCountUser,
            'latest_ticket_created_at_' => $latestTicketTimestamp,
        ]);
    }
}
