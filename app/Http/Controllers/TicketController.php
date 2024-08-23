<?php

namespace App\Http\Controllers;

use App\Http\Resources\TicketResource;
use App\Models\Ticket;

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
}
